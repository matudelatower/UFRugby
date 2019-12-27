<?php

namespace App\Entity;

use App\Entity\Base\BaseClass;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FechaRondaRepository")
 */
class FechaRonda extends BaseClass
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="date")
     */
    private $fechaTentativa;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RondaTorneo", inversedBy="fechaRondas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ronda;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Partido", mappedBy="fechaRonda", orphanRemoval=true)
     */
    private $partidos;

	public function __toString() {
		return $this->nombre;
	}
    
    public function __construct()
    {
        $this->partidos = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getFechaTentativa(): ?\DateTimeInterface
    {
        return $this->fechaTentativa;
    }

    public function setFechaTentativa(\DateTimeInterface $fechaTentativa): self
    {
        $this->fechaTentativa = $fechaTentativa;

        return $this;
    }

    public function getRonda(): ?RondaTorneo
    {
        return $this->ronda;
    }

    public function setRonda(?RondaTorneo $ronda): self
    {
        $this->ronda = $ronda;

        return $this;
    }

    /**
     * @return Collection|Partido[]
     */
    public function getPartidos(): Collection
    {
        return $this->partidos;
    }

    public function addPartido(Partido $partido): self
    {
        if (!$this->partidos->contains($partido)) {
            $this->partidos[] = $partido;
            $partido->setFechaRonda($this);
        }

        return $this;
    }

    public function removePartido(Partido $partido): self
    {
        if ($this->partidos->contains($partido)) {
            $this->partidos->removeElement($partido);
            // set the owning side to null (unless already changed)
            if ($partido->getFechaRonda() === $this) {
                $partido->setFechaRonda(null);
            }
        }

        return $this;
    }
}
