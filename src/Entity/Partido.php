<?php

namespace App\Entity;

use App\Entity\Base\BaseClass;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartidoRepository")
 */
class Partido extends BaseClass {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Referee")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $referee;

	/**
	 * @ORM\Column(type="date")
	 */
	private $fecha;

	/**
	 * @ORM\Column(type="time")
	 */
	private $hora;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $sede;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $observaciones;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\EstadoPartido")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $estado;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\FechaRonda", inversedBy="partidos")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $fechaRonda;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\EquipoPartido", mappedBy="partido", orphanRemoval=true, cascade={"persist"})
	 */
	private $equipoPartidos;

	public function __construct() {
		$this->equipoPartidos = new ArrayCollection();
	}

	public function getLocal() {
		foreach ( $this->equipoPartidos as $equipoPartido ) {
			if ( $equipoPartido->getLocal() ) {
				return $equipoPartido;
			}
		}
	}

	public function getVisitante() {
		foreach ( $this->equipoPartidos as $equipoPartido ) {
			if ( $equipoPartido->getVisitante() ) {
				return $equipoPartido;
			}
		}
	}

	public function getId() {
		return $this->id;
	}

	public function getReferee(): ?Referee {
		return $this->referee;
	}

	public function setReferee( ?Referee $referee ): self {
		$this->referee = $referee;

		return $this;
	}

	public function getFecha(): ?\DateTimeInterface {
		return $this->fecha;
	}

	public function setFecha( \DateTimeInterface $fecha ): self {
		$this->fecha = $fecha;

		return $this;
	}

	public function getHora(): ?\DateTimeInterface {
		return $this->hora;
	}

	public function setHora( \DateTimeInterface $hora ): self {
		$this->hora = $hora;

		return $this;
	}

	public function getSede(): ?string {
		return $this->sede;
	}

	public function setSede( string $sede ): self {
		$this->sede = $sede;

		return $this;
	}

	public function getObservaciones(): ?string {
		return $this->observaciones;
	}

	public function setObservaciones( ?string $observaciones ): self {
		$this->observaciones = $observaciones;

		return $this;
	}

	public function getEstado(): ?EstadoPartido {
		return $this->estado;
	}

	public function setEstado( ?EstadoPartido $estado ): self {
		$this->estado = $estado;

		return $this;
	}

	public function getFechaRonda(): ?FechaRonda {
		return $this->fechaRonda;
	}

	public function setFechaRonda( ?FechaRonda $fechaRonda ): self {
		$this->fechaRonda = $fechaRonda;

		return $this;
	}

	/**
	 * @return Collection|EquipoPartido[]
	 */
	public function getEquipoPartidos(): Collection {
		return $this->equipoPartidos;
	}

	public function addEquipoPartido( EquipoPartido $equipoPartido ): self {
		if ( ! $this->equipoPartidos->contains( $equipoPartido ) ) {
			$this->equipoPartidos[] = $equipoPartido;
			$equipoPartido->setPartido( $this );
		}

		return $this;
	}

	public function removeEquipoPartido( EquipoPartido $equipoPartido ): self {
		if ( $this->equipoPartidos->contains( $equipoPartido ) ) {
			$this->equipoPartidos->removeElement( $equipoPartido );
			// set the owning side to null (unless already changed)
			if ( $equipoPartido->getPartido() === $this ) {
				$equipoPartido->setPartido( null );
			}
		}

		return $this;
	}
}
