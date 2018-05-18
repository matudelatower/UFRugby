<?php

namespace App\Entity;

use App\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * ResponsableJugador
 *
 * @ORM\Table(name="responsable_jugador")
 * @ORM\Entity(repositoryClass="App\Repository\ResponsableJugadorRepository")
 */
class ResponsableJugador extends BaseClass
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
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\Persona", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
	 */
	private $persona;

	/**
	 * @var
	 *
	 * @ORM\OneToOne(targetEntity="App\Entity\Jugador", cascade={"persist"})
	 * @ORM\JoinColumn(name="jugador_id", referencedColumnName="id")
	 */
	private $jugador;


	/**
	 * @var
	 *
	 * @ORM\OneToOne(targetEntity="App\Entity\TipoRelacion", cascade={"persist"})
	 * @ORM\JoinColumn(name="tipo_relacion_id", referencedColumnName="id")
	 */
	private $tipoRelacion;


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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return ResponsableJugador
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
     * @return ResponsableJugador
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    /**
     * Set persona
     *
     * @param \App\Entity\Persona $persona
     *
     * @return ResponsableJugador
     */
    public function setPersona(\App\Entity\Persona $persona = null)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \App\Entity\Persona
     */
    public function getPersona()
    {
        return $this->persona;
    }

    /**
     * Set jugador
     *
     * @param \App\Entity\Jugador $jugador
     *
     * @return ResponsableJugador
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
     * Set tipoRelacion
     *
     * @param \App\Entity\TipoRelacion $tipoRelacion
     *
     * @return ResponsableJugador
     */
    public function setTipoRelacion(\App\Entity\TipoRelacion $tipoRelacion = null)
    {
        $this->tipoRelacion = $tipoRelacion;

        return $this;
    }

    /**
     * Get tipoRelacion
     *
     * @return \App\Entity\TipoRelacion
     */
    public function getTipoRelacion()
    {
        return $this->tipoRelacion;
    }

    /**
     * Set creadoPor
     *
     * @param \App\Entity\Usuario $creadoPor
     *
     * @return ResponsableJugador
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
     * @return ResponsableJugador
     */
    public function setActualizadoPor(\App\Entity\Usuario $actualizadoPor = null)
    {
        $this->actualizadoPor = $actualizadoPor;

        return $this;
    }
}
