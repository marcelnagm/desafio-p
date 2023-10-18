<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use \App\Trait\ArrayExpressible;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task {

use ArrayExpressible;

#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column]
private ?int $id = null;

#[Assert\NotBlank]
#[ORM\Column(length: 255)]
private ?string $description = null;

#[Assert\NotBlank]
#[ORM\Column(length: 255)]
private ?string $expire_at = null;

#[Assert\NotBlank]
#[ORM\Column]
private ?\DateTimeImmutable $created_at = null;

#[ORM\Column(type: Types::BIGINT)]
private ?string $created_by = null;

#[ORM\Column(length: 255, nullable: true)]
private ?string $finished_at = null;

#[Assert\NotBlank]
#[ORM\Column(type: Types::BIGINT)]
private ?string $tasklist_id = null;

public function __construct() {
$this->setCreatedAt(new \DateTimeImmutable());
}

public function getId(): ?int {
return $this->id;
}

public function getDescription(): ?string {
return $this->description;
}

public function setDescription(string $description): static {
$this->description = $description;

return $this;
}

public function getExpireAt(): ?string {
return $this->expire_at;
}

public function setExpireAt(string $expire_at): static {
$this->expire_at = $expire_at;

return $this;
}

public function getCreatedAt(): ?\DateTimeImmutable {
return $this->created_at;
}

public function setCreatedAt(\DateTimeImmutable $created_at): static {
$this->created_at = $created_at;

return $this;
}

public function getCreatedBy(): ?string {
return $this->created_by;
}

public function setCreatedBy(string $created_by): static {
$this->created_by = $created_by;

return $this;
}

public function getFinishedAt(): ?string {
return $this->finished_at;
}

public function setFinishedAt(?string $finished_at): static {
$this->finished_at = $finished_at;

return $this;
}

public function getTasklistId(): ?string {
return $this->tasklist_id;
}

public function setTasklistId(string $tasklist_id): static {
$this->tasklist_id = $tasklist_id;

return $this;
}
}
