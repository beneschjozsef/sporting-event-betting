<?php

// app/Services/EventManagementService.php

namespace App\Services;

use App\Entities\Event;
use Doctrine\ORM\EntityManagerInterface;
use App\Entities\User;
use App\Entities\Participant;

class EventManagementService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createEvent(string $title, \DateTimeInterface $date, User $creator, array $participantsData)
    {
        $event = new Event();
        $event->setTitle($title);
        $event->setDate($date);
        $event->setCreator($creator);

        foreach ($participantsData as $participantData) {
            $participant = new Participant();
            $participant->setName($participantData['name']);
            $participant->setRole($participantData['role']);
            $participant->setDescription($participantData['description'] ?? null);

            $this->entityManager->persist($participant);
            $event->addParticipant($participant);
        }

        $this->entityManager->persist($event);
        $this->entityManager->flush();

        return $event;
    }

    public function editEvent(Event $event, string $title, \DateTimeInterface $date, array $participantsData)
    {
        $event->setTitle($title);
        $event->setDate($date);

        foreach ($event->getParticipants() as $eventParticipant) {
            $this->entityManager->remove($eventParticipant);
        }
        $event->getParticipants()->clear();

        foreach ($participantsData as $participantData) {
            $participant = new Participant();
            $participant->setName($participantData['name']);
            $participant->setRole($participantData['role']);
            $participant->setDescription($participantData['description'] ?? null);

            $this->entityManager->persist($participant);

            $event->addParticipant($participant);
        }

        $this->entityManager->persist($event);
        $this->entityManager->flush();

        return $event;
    }


    public function deleteEvent(Event $event): void
    {
        foreach ($event->getParticipants() as $eventParticipant) {
            $this->entityManager->remove($eventParticipant);
        }
        $event->getParticipants()->clear();
        $this->entityManager->remove($event);
        $this->entityManager->flush();
    }

    public function getEventById(int $eventId): ?Event
    {
        return $this->entityManager->getRepository(Event::class)->find($eventId);
    }

    public function listEvents(): array
    {
        return $this->entityManager->getRepository(Event::class)->findAll();
    }
}
