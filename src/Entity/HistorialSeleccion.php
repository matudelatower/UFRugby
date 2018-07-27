<?php

namespace App\Entity;

use App\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistorialSeleccionRepository")
 */
class HistorialSeleccion extends BaseClass
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $torneo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TipoSeleccion")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seleccion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Jugador", inversedBy="historialSeleccions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $jugador;

    public function getId()
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getTorneo(): ?string
    {
        return $this->torneo;
    }

    public function setTorneo(string $torneo): self
    {
        $this->torneo = $torneo;

        return $this;
    }

    public function getSeleccion(): ?TipoSeleccion
    {
        return $this->seleccion;
    }

    public function setSeleccion(?TipoSeleccion $seleccion): self
    {
        $this->seleccion = $seleccion;

        return $this;
    }

    public function getJugador(): ?Jugador
    {
        return $this->jugador;
    }

    public function setJugador(?Jugador $jugador): self
    {
        $this->jugador = $jugador;

        return $this;
    }
}
