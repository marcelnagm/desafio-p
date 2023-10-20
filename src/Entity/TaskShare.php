<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TaskShareRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\ByteString;
use App\Trait\ArrayExpressible;


#[ORM\Entity(repositoryClass: TaskShareRepository::class)]
#[ApiResource]
class TaskShare
{
    use ArrayExpressible;
    
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $shared_with = null;

    #[ORM\Column(length: 255)]
    private ?string $token = null;

    #[ORM\Column(name: 'tasklist_id')]
    #[ORM\ManyToOne(inversedBy: 'taskshares')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TaskList $tasklist_id = null;

    #[ORM\Column(name: 'createdgfdgfdgd')]
    #[ORM\ManyToOne(inversedBy: 'taskShares')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $created_by = null;


    public function __construct() {
        $this->setToken(ByteString::fromRandom(32)->toString());
    }
     
     
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTasklistId(): ?string
    {
        return $this->tasklist_id;
    }

    public function setTasklistId(string $tasklist_id): static
    {
        $this->tasklist_id = $tasklist_id;

        return $this;
    }

    public function getSharedWith(): ?string
    {
        return $this->shared_with;
    }

    public function setSharedWith(string $shared_with): static
    {
        $this->shared_with = $shared_with;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->created_by;
    }

    public function setCreatedBy(string $created_by): static
    {
        $this->created_by = $created_by;

        return $this;
    }
}
