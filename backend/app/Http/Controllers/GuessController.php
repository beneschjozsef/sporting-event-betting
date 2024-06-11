<?php

namespace App\Http\Controllers;

use App\Services\GuessManagementService;
use App\Services\EventManagementService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Doctrine\ORM\EntityManagerInterface;
use App\Entities\Event;
use App\Entities\Participant;
use App\Services\TokenService;

class GuessController extends Controller
{
    private $guessService;
    private $entityManager;
    private $eventService;
    private $tokenService;

    public function __construct(
        GuessManagementService $guessService,
        EventManagementService $eventService,
        TokenService $tokenService,
        EntityManagerInterface $entityManager
    ) {
        $this->guessService = $guessService;
        $this->eventService = $eventService;
        $this->tokenService = $tokenService;
        $this->entityManager = $entityManager;
    }

    public function createGuess(Request $request)
    {
        $token = $request->bearerToken();
        $user = $this->tokenService->getUserByToken($token);

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $eventId = $request->input('event_id');
        $participantId = $request->input('participant_id');

        $event = $this->entityManager->getRepository(Event::class)->find($eventId);
        $participant = $this->entityManager->getRepository(Participant::class)->find($participantId);

        if (!$event || !$participant) {
            return response()->json(['message' => 'Event or participant not found'], 404);
        }

        $guess = $this->guessService->createGuess($user, $event, $participant);

        if (!$guess) {
            return response()->json(['message' => 'You have already guessed for this event'], 400);
        }

        return response()->json($guess);
    }
}
