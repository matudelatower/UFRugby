<?php

namespace App\Entity;

use App\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * PagoJugador
 *
 * @ORM\Table(name="pagos_jugador")
 * @ORM\Entity(repositoryClass="App\Repository\PagoJugadorRepository")
 */
class PagoJugador extends BaseClass
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal", precision=10, scale=2)
     */
    private $monto;

    /**
     * @var string
     *
     * @ORM\Column(name="mes", type="string", length=255)
     */
    private $mes;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\Jugador", cascade={"persist"})
	 * @ORM\JoinColumn(name="jugador_id", referencedColumnName="id")
	 */
	private $jugador;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\Club", cascade={"persist"})
	 * @ORM\JoinColumn(name="club_id", referencedColumnName="id")
	 */
	private $club;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="concepto", type="string", length=255, nullable=true)
	 */
	private $concepto;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return PagoJugador
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set monto
     *
     * @param string $monto
     *
     * @return PagoJugador
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set mes
     *
     * @param string $mes
     *
     * @return PagoJugador
     */
    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    /**
     * Get mes
     *
     * @return string
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return PagoJugador
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Set fechaActualizacion
     *
     * @param \DateTime $fechaActualizacion
     *
     * @return PagoJugador
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    /**
     * Set jugador
     *
     * @param \App\Entity\Jugador $jugador
     *
     * @return PagoJugador
     */
    public function setJugador(\App\Entity\Jugador $jugador = null)
    {
        $this->jugador = $jugador;

        return $this;
    }

    /**
     * Get jugador
     *
     * @return \App\Entity\Jugador
     */
    public function getJugador()
    {
        return $this->jugador;
    }

    /**
     * Set creadoPor
     *
     * @param \App\Entity\Usuario $creadoPor
     *
     * @return PagoJugador
     */
    public function setCreadoPor(\App\Entity\Usuario $creadoPor = null)
    {
        $this->creadoPor = $creadoPor;

        return $this;
    }

    /**
     * Set actualizadoPor
     *
     * @param \App\Entity\Usuario $actualizadoPor
     *
     * @return PagoJugador
     */
    public function setActualizadoPor(\App\Entity\Usuario $actualizadoPor = null)
    {
        $this->actualizadoPor = $actualizadoPor;

        return $this;
    }

    /**
     * Set club
     *
     * @param \App\Entity\Club $club
     *
     * @return PagoJugador
     */
    public function setClub(\App\Entity\Club $club = null)
    {
        $this->club = $club;

        return $this;
    }

	/**
	 * @return string
	 */
	public function getConcepto() {
		return $this->concepto;
	}

	/**
	 * @param string $concepto
	 */
	public function setConcepto( string $concepto ): void {
		$this->concepto = $concepto;
	}

    /**
     * Get club
     *
     * @return \App\Entity\Club
     */
    public function getClub()
    {
        return $this->club;
    }
}
