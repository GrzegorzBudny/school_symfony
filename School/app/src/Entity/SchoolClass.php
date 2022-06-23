<?php

namespace App\Entity;

use App\Repository\SchoolClassRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SchoolClassRepository::class)]
class SchoolClass
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 1)]
    private $ClassName;

    #[ORM\ManyToOne(targetEntity: Teacher::class)]
    private $Tutor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClassName(): ?string
    {
        return $this->ClassName;
    }

    public function setClassName(string $ClassName): self
    {
        $this->ClassName = $ClassName;

        return $this;
    }

    public function getTutor(): ?Teacher
    {
        return $this->Tutor;
    }

    public function setTutor(?Teacher $Tutor): self
    {
        $this->Tutor = $Tutor;

        return $this;
    }
}
