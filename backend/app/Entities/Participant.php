<?php

// app/Entities/Participant.php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use InvalidArgumentException;

/**
 * @ORM\Entity
 * @ORM\Table(name="participants")
 */
class Participant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="Event", mappedBy="participants")
     */
    protected $events;

    const VALID_ROLES = ['individual', 'team'];

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        if (!in_array($role, self::VALID_ROLES)) {
            throw new InvalidArgumentException("Invalid role: $role. Valid roles are 'individual' and 'team'.");
        }
        $this->role = $role;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function addEvent(Event $event)
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
        }
    }
}
