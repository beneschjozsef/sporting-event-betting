<?php

namespace App\Services;

use App\Entities\Guess;
use App\Entities\Event;
use App\Entities\Participant;
use App\Entities\User;
use Doctrine\ORM\EntityManagerInterface;

class GuessManagementService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createGuess(User $user, Event $event, Participant $participant): ?Guess
    {
        $existingGuess = $this->entityManager->getRepository(Guess::class)->findOneBy([
            'user' => $user,
            'event' => $event
        ]);

        if ($existingGuess) {
            return null;
        }
        $guess = new Guess();
        $guess->setUser($user);
        $guess->setEvent($event);
        $guess->setParticipant($participant);

        $this->entityManager->persist($guess);
        $this->entityManager->flush();

        return $guess;
    }
}
