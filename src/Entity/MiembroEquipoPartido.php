<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MiembroEquipoPartidoRepository")
 */
class MiembroEquipoPartido
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EquipoPartido", inversedBy="miembroEquipoPartidos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipoPartido;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Jugador")
     * @ORM\JoinColumn(nullable=false)
     */
    private $jugador;

    /**
     * @ORM\Column(type="boolean")
     */
    private $titular;

    /**
     * @ORM\Column(type="boolean")
     */
    private $suplente;

    public function getId()
    {
        return $this->id;
    }

    public function getEquipoPartido(): ?EquipoPartido
    {
        return $this->equipoPartido;
    }

    public function setEquipoPartido(?EquipoPartido $equipoPartido): self
    {
        $this->equipoPartido = $equipoPartido;

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

    public function getTitular(): ?bool
    {
        return $this->titular;
    }

    public function setTitular(bool $titular): self
    {
        $this->titular = $titular;

        return $this;
    }

    public function getSuplente(): ?bool
    {
        return $this->suplente;
    }

    public function setSuplente(bool $suplente): self
    {
        $this->suplente = $suplente;

        return $this;
    }
}
