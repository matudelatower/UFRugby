<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * PagoClub
 *
 * @ORM\Table(name="pagos_club")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PagoClubRepository")
 */
class PagoClub extends BaseClass {
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
	 * @ORM\Column(name="fecha", type="datetime")
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
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Club", cascade={"persist"})
	 * @ORM\JoinColumn(name="club_id", referencedColumnName="id")
	 */
	private $club;


	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set fecha
	 *
	 * @param \DateTime $fecha
	 *
	 * @return PagoClub
	 */
	public function setFecha( $fecha ) {
		$this->fecha = $fecha;

		return $this;
	}

	/**
	 * Get fecha
	 *
	 * @return \DateTime
	 */
	public function getFecha() {
		return $this->fecha;
	}

	/**
	 * Set monto
	 *
	 * @param string $monto
	 *
	 * @return PagoClub
	 */
	public function setMonto( $monto ) {
		$this->monto = $monto;

		return $this;
	}

	/**
	 * Get monto
	 *
	 * @return string
	 */
	public function getMonto() {
		return $this->monto;
	}

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return PagoClub
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
     * @return PagoClub
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    /**
     * Set club
     *
     * @param \AppBundle\Entity\Club $club
     *
     * @return PagoClub
     */
    public function setClub(\AppBundle\Entity\Club $club = null)
    {
        $this->club = $club;

        return $this;
    }

    /**
     * Get club
     *
     * @return \AppBundle\Entity\Club
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return PagoClub
     */
    public function setCreadoPor(\UsuariosBundle\Entity\Usuario $creadoPor = null)
    {
        $this->creadoPor = $creadoPor;

        return $this;
    }

    /**
     * Set actualizadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $actualizadoPor
     *
     * @return PagoClub
     */
    public function setActualizadoPor(\UsuariosBundle\Entity\Usuario $actualizadoPor = null)
    {
        $this->actualizadoPor = $actualizadoPor;

        return $this;
    }

    /**
     * Set mes
     *
     * @param string $mes
     *
     * @return PagoClub
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
}
