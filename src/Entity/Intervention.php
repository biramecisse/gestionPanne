<?php

namespace App\Entity;

use App\Repository\InterventionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterventionRepository::class)]
class Intervention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $DirectionEtService = null;

    #[ORM\Column(length: 255)]
    private ?string $TypeDePanne = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $DescrptionDeLaPanne = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDirectionEtService(): ?string
    {
        return $this->DirectionEtService;
    }

    public function setDirectionEtService(string $DirectionEtService): self
    {
        $this->DirectionEtService = $DirectionEtService;

        return $this;
    }

    public function getTypeDePanne(): ?string
    {
        return $this->TypeDePanne;
    }

    public function setTypeDePanne(string $TypeDePanne): self
    {
        $this->TypeDePanne = $TypeDePanne;

        return $this;
    }

    public function getDescrptionDeLaPanne(): ?string
    {
        return $this->DescrptionDeLaPanne;
    }

    public function setDescrptionDeLaPanne(string $DescrptionDeLaPanne): self
    {
        $this->DescrptionDeLaPanne = $DescrptionDeLaPanne;

        return $this;
    }


}
