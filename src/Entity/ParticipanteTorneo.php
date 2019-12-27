<?php

namespace App\Entity;

use App\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipanteTorneoRepository")
 * @UniqueEntity(
 *     fields={"club", "torneo"},
 *     errorPath="club",
 *     message="El club ya participa del Torneo"
 * )
 */
class ParticipanteTorneo extends BaseClass
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Club")
     * @ORM\JoinColumn(nullable=false)
     */
    private $club;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Torneo", inversedBy="participanteTorneos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $torneo;

    public function __toString() {
	    return $this->getClub()->getNombre();
    }

	public function getId()
    {
        return $this->id;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): self
    {
        $this->club = $club;

        return $this;
    }

    public function getTorneo(): ?Torneo
    {
        return $this->torneo;
    }

    public function setTorneo(?Torneo $torneo): self
    {
        $this->torneo = $torneo;

        return $this;
    }
}
