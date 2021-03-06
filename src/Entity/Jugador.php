<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Base\BaseClass;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Jugador
 *
 * @ApiResource()
 * @ORM\Table(name="jugador")
 * @ORM\Entity(repositoryClass="App\Repository\JugadorRepository")
 */
class Jugador extends BaseClass {
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
	 * @ORM\Column(name="peso", type="string", length=255, nullable=true)
	 */
	private $peso;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="altura", type="string", length=255, nullable=true)
	 */
	private $altura;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\Persona", inversedBy="jugador", cascade={"persist"})
	 * @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
	 */
	private $persona;


	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\PosicionJugador")
	 * @ORM\JoinColumn(name="posicion_habitual_id", referencedColumnName="id")
	 */
	private $posicionHabitual;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\PosicionJugador")
	 * @ORM\JoinColumn(name="posicion_alternativa_id", referencedColumnName="id")
	 */
	private $posicionAlternativa;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\PosicionJugador")
	 * @ORM\JoinColumn(name="segunda_posicion_alternativa_id", referencedColumnName="id")
	 */
	private $segundaPosicionAlternativa;

	/**
	 * @var
	 *
	 * @ORM\OneToOne(targetEntity="App\Entity\CondicionJugador")
	 * @ORM\JoinColumn(name="condicion_jugador_id", referencedColumnName="id")
	 */
	private $condicionJugador;

	/**
	 * @var bool
	 *
	 * @ORM\Column(name="dado_de_baja", type="boolean", nullable=true)
	 */
	private $dadoDeBaja;


	/**
	 *
	 * @ORM\OneToMany(targetEntity="App\Entity\ClubJugador", mappedBy="jugador", cascade={"persist", "remove"})
	 */
	private $clubJugador;

	/**
	 *
	 * @ORM\OneToMany(targetEntity="App\Entity\Pase", mappedBy="jugador", cascade={"persist", "remove"})
	 */
	private $pases;

	/**
	* @ORM\OneToMany(targetEntity="App\Entity\HistorialSeleccion", mappedBy="jugador", orphanRemoval=true)
	*/
	private $historialSeleccions;

	public function __toString() {
		return $this->persona->__toString();
	}


	/**
	 * Constructor
	 */
	public function __construct() {
		$this->clubJugador = new \Doctrine\Common\Collections\ArrayCollection();
		$this->pases = new \Doctrine\Common\Collections\ArrayCollection();
        $this->historialSeleccions = new ArrayCollection();
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
	 * Set peso
	 *
	 * @param string $peso
	 *
	 * @return Jugador
	 */
	public function setPeso( $peso ) {
		$this->peso = $peso;

		return $this;
	}

	/**
	 * Get peso
	 *
	 * @return string
	 */
	public function getPeso() {
		return $this->peso;
	}

	/**
	 * Set altura
	 *
	 * @param string $altura
	 *
	 * @return Jugador
	 */
	public function setAltura( $altura ) {
		$this->altura = $altura;

		return $this;
	}

	/**
	 * Get altura
	 *
	 * @return string
	 */
	public function getAltura() {
		return $this->altura;
	}

	/**
	 * Set dadoDeBaja
	 *
	 * @param boolean $dadoDeBaja
	 *
	 * @return Jugador
	 */
	public function setDadoDeBaja( $dadoDeBaja ) {
		$this->dadoDeBaja = $dadoDeBaja;

		return $this;
	}

	/**
	 * Get dadoDeBaja
	 *
	 * @return boolean
	 */
	public function getDadoDeBaja() {
		return $this->dadoDeBaja;
	}

	/**
	 * Set fechaCreacion
	 *
	 * @param \DateTime $fechaCreacion
	 *
	 * @return Jugador
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
	 * @return Jugador
	 */
	public function setFechaActualizacion( $fechaActualizacion ) {
		$this->fechaActualizacion = $fechaActualizacion;

		return $this;
	}

	/**
	 * Set persona
	 *
	 * @param \App\Entity\Persona $persona
	 *
	 * @return Jugador
	 */
	public function setPersona( \App\Entity\Persona $persona = null ) {
		$this->persona = $persona;

		return $this;
	}

	/**
	 * Get persona
	 *
	 * @return \App\Entity\Persona
	 */
	public function getPersona() {
		return $this->persona;
	}

	/**
	 * Set posicionHabitual
	 *
	 * @param \App\Entity\PosicionJugador $posicionHabitual
	 *
	 * @return Jugador
	 */
	public function setPosicionHabitual( \App\Entity\PosicionJugador $posicionHabitual = null ) {
		$this->posicionHabitual = $posicionHabitual;

		return $this;
	}

	/**
	 * Get posicionHabitual
	 *
	 * @return \App\Entity\PosicionJugador
	 */
	public function getPosicionHabitual() {
		return $this->posicionHabitual;
	}

	/**
	 * Set posicionAlternativa
	 *
	 * @param \App\Entity\PosicionJugador $posicionAlternativa
	 *
	 * @return Jugador
	 */
	public function setPosicionAlternativa( \App\Entity\PosicionJugador $posicionAlternativa = null ) {
		$this->posicionAlternativa = $posicionAlternativa;

		return $this;
	}

	/**
	 * Get posicionAlternativa
	 *
	 * @return \App\Entity\PosicionJugador
	 */
	public function getPosicionAlternativa() {
		return $this->posicionAlternativa;
	}

	/**
	 * Set segundaPosicionAlternativa
	 *
	 * @param \App\Entity\PosicionJugador $segundaPosicionAlternativa
	 *
	 * @return Jugador
	 */
	public function setSegundaPosicionAlternativa( \App\Entity\PosicionJugador $segundaPosicionAlternativa = null
	) {
		$this->segundaPosicionAlternativa = $segundaPosicionAlternativa;

		return $this;
	}

	/**
	 * Get segundaPosicionAlternativa
	 *
	 * @return \App\Entity\PosicionJugador
	 */
	public function getSegundaPosicionAlternativa() {
		return $this->segundaPosicionAlternativa;
	}

	/**
	 * Set condicionJugador
	 *
	 * @param \App\Entity\CondicionJugador $condicionJugador
	 *
	 * @return Jugador
	 */
	public function setCondicionJugador( \App\Entity\CondicionJugador $condicionJugador = null ) {
		$this->condicionJugador = $condicionJugador;

		return $this;
	}

	/**
	 * Get condicionJugador
	 *
	 * @return \App\Entity\CondicionJugador
	 */
	public function getCondicionJugador() {
		return $this->condicionJugador;
	}

	/**
	 * Add clubJugador
	 *
	 * @param \App\Entity\ClubJugador $clubJugador
	 *
	 * @return Jugador
	 */
	public function addClubJugador( \App\Entity\ClubJugador $clubJugador ) {

		if (!$this->clubJugador->contains($clubJugador)) {
			$this->clubJugador[] = $clubJugador;
			$clubJugador->setJugador($this);
		}

		return $this;
	}

	/**
	 * Remove clubJugador
	 *
	 * @param \App\Entity\ClubJugador $clubJugador
	 */
	public function removeClubJugador( \App\Entity\ClubJugador $clubJugador ) {
		$this->clubJugador->removeElement( $clubJugador );
	}

	/**
	 * Get clubJugador
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getClubJugador() {
		return $this->clubJugador;
	}

	/**
	 * Set creadoPor
	 *
	 * @param \App\Entity\Usuario $creadoPor
	 *
	 * @return Jugador
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
	 * @return Jugador
	 */
	public function setActualizadoPor( \App\Entity\Usuario $actualizadoPor = null ) {
		$this->actualizadoPor = $actualizadoPor;

		return $this;
	}


	public function addPases( \App\Entity\Pase $pase ) {

		if (!$this->pases->contains($pase)) {
			$this->pases[] = $pase;
			$pase->setJugador($this);
		}

		return $this;
	}

	/**
	 * Remove pase
	 *
	 * @param \App\Entity\Pase $pase
	 */
	public function removePases( \App\Entity\Pase $pase ) {
		$this->pases->removeElement( $pase );
	}

	/**
	 * Get pase
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getPases() {
		return $this->pases;
	}

	/**
	 * @return Collection|HistorialSeleccion[]
	 */
	public function getHistorialSeleccions(): Collection {
		return $this->historialSeleccions;
	}

	public function addHistorialSeleccion( HistorialSeleccion $historialSeleccion ): self {
		if ( ! $this->historialSeleccions->contains( $historialSeleccion ) ) {
			$this->historialSeleccions[] = $historialSeleccion;
			$historialSeleccion->setJugador( $this );
		}

		return $this;
	}

	public function removeHistorialSeleccion( HistorialSeleccion $historialSeleccion ): self {
		if ( $this->historialSeleccions->contains( $historialSeleccion ) ) {
			$this->historialSeleccions->removeElement( $historialSeleccion );
			// set the owning side to null (unless already changed)
			if ( $historialSeleccion->getJugador() === $this ) {
				$historialSeleccion->setJugador( null );
			}
		}

		return $this;
	}
}
