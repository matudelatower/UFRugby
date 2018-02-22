<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * ResponsableJugador
 *
 * @ORM\Table(name="responsable_jugador")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResponsableJugadorRepository")
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
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\Persona", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
	 */
	private $persona;

	/**
	 * @var
	 *
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\Jugador", cascade={"persist"})
	 * @ORM\JoinColumn(name="jugador_id", referencedColumnName="id")
	 */
	private $jugador;


	/**
	 * @var
	 *
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\TipoRelacion", cascade={"persist"})
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
     * @param \AppBundle\Entity\Persona $persona
     *
     * @return ResponsableJugador
     */
    public function setPersona(\AppBundle\Entity\Persona $persona = null)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \AppBundle\Entity\Persona
     */
    public function getPersona()
    {
        return $this->persona;
    }

    /**
     * Set jugador
     *
     * @param \AppBundle\Entity\Jugador $jugador
     *
     * @return ResponsableJugador
     */
    public function setJugador(\AppBundle\Entity\Jugador $jugador = null)
    {
        $this->jugador = $jugador;

        return $this;
    }

    /**
     * Get jugador
     *
     * @return \AppBundle\Entity\Jugador
     */
    public function getJugador()
    {
        return $this->jugador;
    }

    /**
     * Set tipoRelacion
     *
     * @param \AppBundle\Entity\TipoRelacion $tipoRelacion
     *
     * @return ResponsableJugador
     */
    public function setTipoRelacion(\AppBundle\Entity\TipoRelacion $tipoRelacion = null)
    {
        $this->tipoRelacion = $tipoRelacion;

        return $this;
    }

    /**
     * Get tipoRelacion
     *
     * @return \AppBundle\Entity\TipoRelacion
     */
    public function getTipoRelacion()
    {
        return $this->tipoRelacion;
    }

    /**
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return ResponsableJugador
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
     * @return ResponsableJugador
     */
    public function setActualizadoPor(\UsuariosBundle\Entity\Usuario $actualizadoPor = null)
    {
        $this->actualizadoPor = $actualizadoPor;

        return $this;
    }
}
