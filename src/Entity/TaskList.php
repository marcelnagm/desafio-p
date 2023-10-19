<?php

namespace App\Entity;

use App\Repository\TaskListRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use \App\Trait\ArrayExpressible;
use Doctrine\ORM\PersistentCollection;

#[ORM\Entity(repositoryClass: TaskListRepository::class)]
class TaskList {

    use ArrayExpressible;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $created_by = null;

    #[ORM\Column(length: 50)]
    private ?string $description = null;

    #[ORM\OneToMany(targetEntity: "Task", mappedBy: "tasklist")]
    private $tasks;

    #[ORM\ManyToOne(targetEntity: "User", inversedBy: "tasklist")]
    #[ORM\JoinColumn(name: 'created_by', referencedColumnName: "id")]
    private $user;

    /**
     * @return Collection|Booking[]
     */
    public function getId(): ?int {
        return $this->id;
    }

    public function getCreatedBy(): ?string {
        return $this->created_by;
    }

    public function setCreatedBy(string $created_by): static {
        $this->created_by = $created_by;

        return $this;
    }

//
//    public function getTasks(): PersistentCollection {
//        return $this->tasks;
//    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(string $description): static {
        $this->description = $description;

        return $this;
    }

    public function getTasks() {
        return $this->tasks;
    }
}
