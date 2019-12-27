<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IncidenciaRepository")
 */
class Incidencia
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $minuto;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observacion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TiempoIncidencia")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tiempo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TipoIncidencia")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tipoIncidencia;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MiembroEquipoPartido")
     */
    private $jugador;

    public function getId()
    {
        return $this->id;
    }

    public function getMinuto(): ?int
    {
        return $this->minuto;
    }

    public function setMinuto(?int $minuto): self
    {
        $this->minuto = $minuto;

        return $this;
    }

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function setObservacion(?string $observacion): self
    {
        $this->observacion = $observacion;

        return $this;
    }

    public function getTiempo(): ?TiempoIncidencia
    {
        return $this->tiempo;
    }

    public function setTiempo(?TiempoIncidencia $tiempo): self
    {
        $this->tiempo = $tiempo;

        return $this;
    }

    public function getTipoIncidencia(): ?TipoIncidencia
    {
        return $this->tipoIncidencia;
    }

    public function setTipoIncidencia(?TipoIncidencia $tipoIncidencia): self
    {
        $this->tipoIncidencia = $tipoIncidencia;

        return $this;
    }

    public function getJugador(): ?MiembroEquipoPartido
    {
        return $this->jugador;
    }

    public function setJugador(?MiembroEquipoPartido $jugador): self
    {
        $this->jugador = $jugador;

        return $this;
    }
}
