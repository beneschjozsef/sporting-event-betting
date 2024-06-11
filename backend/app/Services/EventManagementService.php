<?php

// app/Services/EventManagementService.php

namespace App\Services;

use App\Entities\Event;
use Doctrine\ORM\EntityManagerInterface;
use App\Entities\User;
use App\Entities\Participant;
use App\Entities\Guess;

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
        $events = $this->entityManager->getRepository(Event::class)->findAll();
        $result = [];

        foreach ($events as $event) {
            $eventData = [
                'id' => $event->getId(),
                'title' => $event->getTitle(),
                'date' => $event->getDate()->format('Y-m-d H:i:s'),
                'creator' => [
                    'id' => $event->getCreator()->getId(),
                    'name' => $event->getCreator()->getName(),
                    'email' => $event->getCreator()->getEmail(),
                ],
                'participants' => [],
            ];

            foreach ($event->getParticipants() as $participant) {
                $tipsCount = $this->countTipsForParticipant($participant);

                $participantData = [
                    'id' => $participant->getId(),
                    'name' => $participant->getName(),
                    'role' => $participant->getRole(),
                    'description' => $participant->getDescription(),
                    'tipsCount' => $tipsCount,
                ];

                $eventData['participants'][] = $participantData;
            }

            $result[] = $eventData;
        }

        return $result;
    }

    public function countTipsForParticipant(Participant $participant): int
    {
        return (int) $this->entityManager->createQueryBuilder()
            ->select('count(t.id)')
            ->from(Guess::class, 't')
            ->where('t.participant = :participant')
            ->setParameter('participant', $participant)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
