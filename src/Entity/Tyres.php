<?php

namespace App\Entity;

use App\Repository\TyresRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TyresRepository::class)]
class Tyres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $width = null;

    #[ORM\Column(length: 10)]
    private ?string $diameter = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $seasonality = null;

    #[ORM\Column]
    private ?int $profile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getDiameter(): ?string
    {
        return $this->diameter;
    }

    public function setDiameter(string $diameter): static
    {
        $this->diameter = $diameter;

        return $this;
    }

    public function getSeasonality(): ?string
    {
        return $this->seasonality;
    }

    public function setSeasonality(?string $seasonality): static
    {
        $this->seasonality = $seasonality;

        return $this;
    }

    public function getProfile(): ?int
    {
        return $this->profile;
    }

    public function setProfile(int $profile): static
    {
        $this->profile = $profile;

        return $this;
    }
}
