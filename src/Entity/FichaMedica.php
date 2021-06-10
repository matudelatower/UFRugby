<?php

namespace App\Entity;

use App\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * FichaMedica
 *
 * @ORM\Table(name="ficha_medica")
 * @ORM\Entity(repositoryClass="App\Repository\FichaMedicaRepository")
 */
class FichaMedica extends BaseClass {
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
	 * @ORM\Column(name="prestador", type="string", length=255, nullable=true)
	 */
	private $prestador;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="numero_afiliado", type="string", length=255, nullable=true)
	 */
	private $numeroAfiliado;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\ClubJugador", inversedBy="fichaMedica")
	 * @ORM\JoinColumn(name="club_jugador_id", referencedColumnName="id")
	 */
	private $clubJugador;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\GrupoSanguineo")
	 * @ORM\JoinColumn(name="grupo_sanguineo_id", referencedColumnName="id")
	 */
	private $grupoSanguineo;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="tiene_cobertura", type="boolean", nullable=true)
	 */
	private $tieneCobertura;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="doctor", type="string", length=255, nullable=true)
	 */
	private $doctor;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="matricula", type="string", length=255, nullable=true)
	 */
	private $matricula;


	public function __toString() {
		return 'Afiliado: ' . $this->numeroAfiliado;
	}

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set prestador
	 *
	 * @param string $prestador
	 *
	 * @return FichaMedica
	 */
	public function setPrestador( $prestador ) {
		$this->prestador = $prestador;

		return $this;
	}

	/**
	 * Get prestador
	 *
	 * @return string
	 */
	public function getPrestador() {
		return $this->prestador;
	}

	/**
	 * Set numeroAfiliado
	 *
	 * @param string $numeroAfiliado
	 *
	 * @return FichaMedica
	 */
	public function setNumeroAfiliado( $numeroAfiliado ) {
		$this->numeroAfiliado = $numeroAfiliado;

		return $this;
	}

	/**
	 * Get numeroAfiliado
	 *
	 * @return string
	 */
	public function getNumeroAfiliado() {
		return $this->numeroAfiliado;
	}

	/**
	 * Set tieneCobertura
	 *
	 * @param boolean $tieneCobertura
	 *
	 * @return FichaMedica
	 */
	public function setTieneCobertura( $tieneCobertura ) {
		$this->tieneCobertura = $tieneCobertura;

		return $this;
	}

	/**
	 * Get tieneCobertura
	 *
	 * @return boolean
	 */
	public function getTieneCobertura() {
		return $this->tieneCobertura;
	}

	/**
	 * Set fechaCreacion
	 *
	 * @param \DateTime $fechaCreacion
	 *
	 * @return FichaMedica
	 */
	public function setFechaCreacion( $fechaCreacion ) {
		$this->fechaCreacion = $fechaCreacion;

		return $this;
	}

	/**
	 * Set fechaActualizacion
	 *
	 * @param \DateTime $fechaActualizacion
	 *
	 * @return FichaMedica
	 */
	public function setFechaActualizacion( $fechaActualizacion ) {
		$this->fechaActualizacion = $fechaActualizacion;

		return $this;
	}


	/**
	 * Set grupoSanguineo
	 *
	 * @param \App\Entity\GrupoSanguineo $grupoSanguineo
	 *
	 * @return FichaMedica
	 */
	public function setGrupoSanguineo( \App\Entity\GrupoSanguineo $grupoSanguineo = null ) {
		$this->grupoSanguineo = $grupoSanguineo;

		return $this;
	}

	/**
	 * Get grupoSanguineo
	 *
	 * @return \App\Entity\GrupoSanguineo
	 */
	public function getGrupoSanguineo() {
		return $this->grupoSanguineo;
	}

	/**
	 * Set creadoPor
	 *
	 * @param \App\Entity\Usuario $creadoPor
	 *
	 * @return FichaMedica
	 */
	public function setCreadoPor( \App\Entity\Usuario $creadoPor = null ) {
		$this->creadoPor = $creadoPor;

		return $this;
	}

	/**
	 * Set actualizadoPor
	 *
	 * @param \App\Entity\Usuario $actualizadoPor
	 *
	 * @return FichaMedica
	 */
	public function setActualizadoPor( \App\Entity\Usuario $actualizadoPor = null ) {
		$this->actualizadoPor = $actualizadoPor;

		return $this;
	}

	/**
	 * Set doctor
	 *
	 * @param string $doctor
	 *
	 * @return FichaMedica
	 */
	public function setDoctor( $doctor ) {
		$this->doctor = $doctor;

		return $this;
	}

	/**
	 * Get doctor
	 *
	 * @return string
	 */
	public function getDoctor() {
		return $this->doctor;
	}

	/**
	 * Set matricula
	 *
	 * @param string $matricula
	 *
	 * @return FichaMedica
	 */
	public function setMatricula( $matricula ) {
		$this->matricula = $matricula;

		return $this;
	}

	/**
	 * Get matricula
	 *
	 * @return string
	 */
	public function getMatricula() {
		return $this->matricula;
	}

	/**
	 * Set clubJugador
	 *
	 * @param \App\Entity\ClubJugador $clubJugador
	 *
	 * @return FichaMedica
	 */
	public function setClubJugador( \App\Entity\ClubJugador $clubJugador = null ) {
		$this->clubJugador = $clubJugador;

		return $this;
	}

	/**
	 * Get clubJugador
	 *
	 * @return \App\Entity\ClubJugador
	 */
	public function getClubJugador() {
		return $this->clubJugador;
	}
}
