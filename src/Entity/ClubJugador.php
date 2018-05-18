<?php

namespace App\Entity;

use App\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * ClubJugador
 *
 * @ORM\Table(name="club_jugador")
 * @ORM\Entity(repositoryClass="App\Repository\ClubJugadorRepository")
 */
class ClubJugador extends BaseClass {

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
	 * @ORM\ManyToOne(targetEntity="App\Entity\Club", inversedBy="jugador", cascade={"persist"})
	 * @ORM\JoinColumn(name="club_id", referencedColumnName="id")
	 */
	private $club;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\Jugador", inversedBy="clubJugador", cascade={"persist","remove"})
	 * @ORM\JoinColumn(name="jugador_id", referencedColumnName="id")
	 */
	private $jugador;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="anio", type="integer")
	 */
	private $anio;


	/**
	 * @var string
	 *
	 * @ORM\Column(name="token_confirmacion", type="string", length=255, nullable=true)
	 */
	private $tokenConfirmacion;


	/**
	 * @var bool
	 *
	 * @ORM\Column(name="confirmado", type="boolean", nullable=true)
	 */
	private $confirmado;

	/**
	 * @var bool
	 *
	 * @ORM\Column(name="consentimiento", type="boolean")
	 */
	private $consentimiento;

	/**
	 * @var bool
	 *
	 * @ORM\Column(name="confirmado_union", type="boolean", nullable=true)
	 */
	private $confirmadoUnion = false;

	/**
	 * @var
	 * @ORM\Column(name="fecha_confirmacion_union", type="date", nullable=true)
	 */
	private $fechaConfirmacionUnion;

	/**
	 * @var bool
	 *
	 * @ORM\Column(name="confirmado_club", type="boolean", nullable=true)
	 */
	private $confirmadoClub = false;

	/**
	 * @var
	 * @ORM\Column(name="fecha_confirmacion_club", type="date", nullable=true)
	 */
	private $fechaConfirmacionClub;

	/**
	 *
	 * @ORM\OneToMany(targetEntity="App\Entity\FichaMedica", mappedBy="clubJugador", cascade={"persist", "remove"})
	 */
	private $fichaMedica;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\Division")
	 * @ORM\JoinColumn(name="division_id", referencedColumnName="id")
	 */
	private $division;

	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set club
	 *
	 * @param \App\Entity\Club $club
	 *
	 * @return ClubJugador
	 */
	public function setClub( \App\Entity\Club $club = null ) {
		$this->club = $club;

		return $this;
	}

	/**
	 * Get club
	 *
	 * @return \App\Entity\Club
	 */
	public function getClub() {
		return $this->club;
	}

	/**
	 * Set jugador
	 *
	 * @param \App\Entity\Jugador $jugador
	 *
	 * @return ClubJugador
	 */
	public function setJugador( \App\Entity\Jugador $jugador = null ) {
		$this->jugador = $jugador;

		return $this;
	}

	/**
	 * Get jugador
	 *
	 * @return \App\Entity\Jugador
	 */
	public function getJugador() {
		return $this->jugador;
	}

    /**
     * Set anio
     *
     * @param integer $anio
     *
     * @return ClubJugador
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return integer
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set tokenConfirmacion
     *
     * @param string $tokenConfirmacion
     *
     * @return ClubJugador
     */
    public function setTokenConfirmacion($tokenConfirmacion)
    {
        $this->tokenConfirmacion = $tokenConfirmacion;

        return $this;
    }

    /**
     * Get tokenConfirmacion
     *
     * @return string
     */
    public function getTokenConfirmacion()
    {
        return $this->tokenConfirmacion;
    }

    /**
     * Set confirmado
     *
     * @param boolean $confirmado
     *
     * @return ClubJugador
     */
    public function setConfirmado($confirmado)
    {
        $this->confirmado = $confirmado;

        return $this;
    }

    /**
     * Get confirmado
     *
     * @return boolean
     */
    public function getConfirmado()
    {
        return $this->confirmado;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return ClubJugador
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
     * @return ClubJugador
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
     * @return ClubJugador
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
     * @return ClubJugador
     */
    public function setActualizadoPor(\App\Entity\Usuario $actualizadoPor = null)
    {
        $this->actualizadoPor = $actualizadoPor;

        return $this;
    }

    /**
     * Set consentimiento
     *
     * @param boolean $consentimiento
     *
     * @return ClubJugador
     */
    public function setConsentimiento($consentimiento)
    {
        $this->consentimiento = $consentimiento;

        return $this;
    }

    /**
     * Get consentimiento
     *
     * @return boolean
     */
    public function getConsentimiento()
    {
        return $this->consentimiento;
    }

    /**
     * Set confirmadoUnion
     *
     * @param boolean $confirmadoUnion
     *
     * @return ClubJugador
     */
    public function setConfirmadoUnion($confirmadoUnion)
    {
        $this->confirmadoUnion = $confirmadoUnion;

        return $this;
    }

    /**
     * Get confirmadoUnion
     *
     * @return boolean
     */
    public function getConfirmadoUnion()
    {
        return $this->confirmadoUnion;
    }

    /**
     * Set fechaConfirmacionUnion
     *
     * @param \DateTime $fechaConfirmacionUnion
     *
     * @return ClubJugador
     */
    public function setFechaConfirmacionUnion($fechaConfirmacionUnion)
    {
        $this->fechaConfirmacionUnion = $fechaConfirmacionUnion;

        return $this;
    }

    /**
     * Get fechaConfirmacionUnion
     *
     * @return \DateTime
     */
    public function getFechaConfirmacionUnion()
    {
        return $this->fechaConfirmacionUnion;
    }

    /**
     * Set confirmadoClub
     *
     * @param boolean $confirmadoClub
     *
     * @return ClubJugador
     */
    public function setConfirmadoClub($confirmadoClub)
    {
        $this->confirmadoClub = $confirmadoClub;

        return $this;
    }

    /**
     * Get confirmadoClub
     *
     * @return boolean
     */
    public function getConfirmadoClub()
    {
        return $this->confirmadoClub;
    }

    /**
     * Set fechaConfirmacionClub
     *
     * @param \DateTime $fechaConfirmacionClub
     *
     * @return ClubJugador
     */
    public function setFechaConfirmacionClub($fechaConfirmacionClub)
    {
        $this->fechaConfirmacionClub = $fechaConfirmacionClub;

        return $this;
    }

    /**
     * Get fechaConfirmacionClub
     *
     * @return \DateTime
     */
    public function getFechaConfirmacionClub()
    {
        return $this->fechaConfirmacionClub;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fichaMedica = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add fichaMedica
     *
     * @param \App\Entity\FichaMedica $fichaMedica
     *
     * @return ClubJugador
     */
    public function addFichaMedica(\App\Entity\FichaMedica $fichaMedica)
    {
        $this->fichaMedica[] = $fichaMedica;

        return $this;
    }

    /**
     * Remove fichaMedica
     *
     * @param \App\Entity\FichaMedica $fichaMedica
     */
    public function removeFichaMedica(\App\Entity\FichaMedica $fichaMedica)
    {
        $this->fichaMedica->removeElement($fichaMedica);
    }

    /**
     * Get fichaMedica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFichaMedica()
    {
        return $this->fichaMedica;
    }

    /**
     * Set division
     *
     * @param \App\Entity\Division $division
     *
     * @return ClubJugador
     */
    public function setDivision(\App\Entity\Division $division = null)
    {
        $this->division = $division;

        return $this;
    }

    /**
     * Get division
     *
     * @return \App\Entity\Division
     */
    public function getDivision()
    {
        return $this->division;
    }
}
