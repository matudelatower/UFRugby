<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Base\BaseClass;

/**
 * Pais
 *
 * @ORM\Table(name="pais")
 * @ORM\Entity(repositoryClass="App\Repository\PaisRepository")
 */
class Pais extends BaseClass {
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nombre", type="string", length=255)
	 */
	private $nombre;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="codigo_pais", type="string", length=255, nullable=true)
	 */
	private $codigoPais;
	/**
	 * @var string
	 *
	 * @ORM\Column(name="codigo_area", type="string", length=255)
	 */
	private $codigoArea;

	public function __toString() {
		return $this->nombre;
	}

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Pais
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set codigoPais
     *
     * @param string $codigoPais
     *
     * @return Pais
     */
    public function setCodigoPais($codigoPais)
    {
        $this->codigoPais = $codigoPais;

        return $this;
    }

    /**
     * Get codigoPais
     *
     * @return string
     */
    public function getCodigoPais()
    {
        return $this->codigoPais;
    }

    /**
     * Set codigoArea
     *
     * @param string $codigoArea
     *
     * @return Pais
     */
    public function setCodigoArea($codigoArea)
    {
        $this->codigoArea = $codigoArea;

        return $this;
    }

    /**
     * Get codigoArea
     *
     * @return string
     */
    public function getCodigoArea()
    {
        return $this->codigoArea;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Pais
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
     * @return Pais
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    /**
     * Set creadoPor
     *
     * @param \App\Entity\Usuario $creadoPor
     *
     * @return Pais
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
     * @return Pais
     */
    public function setActualizadoPor(\App\Entity\Usuario $actualizadoPor = null)
    {
        $this->actualizadoPor = $actualizadoPor;

        return $this;
    }
}
