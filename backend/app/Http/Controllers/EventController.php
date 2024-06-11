<?php

namespace App\Http\Controllers;

use App\Entities\Event;
use App\Services\EventManagementService;
use App\Services\TokenService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Doctrine\ORM\EntityManagerInterface;

class EventController extends Controller
{
    private $eventService;
    private $entityManager;
    private $tokenService;

    public function __construct(EventManagementService $eventService, EntityManagerInterface $entityManager, TokenService $tokenService)
    {
        $this->eventService = $eventService;
        $this->entityManager = $entityManager;
        $this->tokenService = $tokenService;
    }

    public function createEvent(Request $request)
    {
        $token = $request->bearerToken();
        $user = $this->tokenService->getUserByToken($token);

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request = $request->json()->all();

        $title = $request['title'];
        $dateString = $request['date'];
        $date = new \DateTime($dateString);
        $participantsData = $request['participants'];

        $event = $this->eventService->createEvent($title, $date, $user, $participantsData);

        return response()->json($this->getSerializedEvent($event));
    }

    public function editEvent(Request $request, $eventId)
    {
        $token = $request->bearerToken();
        $user = $this->tokenService->getUserByToken($token);

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $event = $this->eventService->getEventById($eventId);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        if ($event->getCreator()->getId() !== $user->getId()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request = $request->json()->all();

        $title = $request['title'] ?? $event->getTitle();
        $dateString = $request['date'] ?? $event->getDate()->format('Y-m-d H:i:s');
        $date = new \DateTime($dateString);
        $participantsData = $request['participants'] ?? [];

        $updatedEvent = $this->eventService->editEvent($event, $title, $date, $participantsData);

        return response()->json($this->getSerializedEvent($updatedEvent));
    }

    public function deleteEvent(Request $request, $eventId)
    {
        $user = $this->tokenService->getUserByToken($request->bearerToken());

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $event = $this->eventService->getEventById($eventId);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        if ($event->getCreator()->getId() !== $user->getId()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $this->eventService->deleteEvent($event);

        return response()->json(['message' => 'Event deleted successfully']);
    }

    public function getEvent($eventId)
    {
        $event = $this->eventService->getEventById($eventId);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return response()->json($this->getSerializedEvent($event));
    }

    public function listEvents()
    {
        $events = $this->eventService->listEvents();

        return response()->json($events);
    }

    private function getSerializedEvent(Event $event)
    {
        return [
            'id' => $event->getId(),
            'title' => $event->getTitle(),
            'date' => $event->getDate()->format('Y-m-d H:i:s'),
            'creator' => [
                'id' => $event->getCreator()->getId(),
                'name' => $event->getCreator()->getName(),
                'email' => $event->getCreator()->getEmail(),
            ],
            'participants' => array_map(function ($participant) {
                return [
                    'id '  => $participant->getId(),
                    'name' => $participant->getName(),
                    'role' => $participant->getRole(),
                    'description' => $participant->getDescription(),
                    'tipsCount' => $this->eventService->countTipsForParticipant($participant),
                ];
            }, $event->getParticipants()->toArray()),
        ];
    }
}
