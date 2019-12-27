<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipoPartidoRepository")
 */
class EquipoPartido {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $fechaConfirmacion;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $estado;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\MiembroEquipoPartido", mappedBy="equipoPartido", cascade={"persist"}, orphanRemoval=true)
	 */
	private $miembroEquipoPartidos;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $local;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $visitante;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\ParticipanteTorneo")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $equipo;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Partido", inversedBy="equipoPartidos")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $partido;

	public function __toString() {
		return $this->equipo->getClub()->getNombre();
	}

	public function getTitulares() {
		$titulares = null;

		foreach ( $this->getMiembroEquipoPartidos() as $miembroEquipoPartido ) {
			if ( $miembroEquipoPartido->getTitular() ) {
				$titulares[] = $miembroEquipoPartido;
			}
		}

		return $titulares;

	}

	public function getSuplentes() {
		$suplentes = null;

		foreach ( $this->getMiembroEquipoPartidos() as $miembroEquipoPartido ) {
			if ( $miembroEquipoPartido->getSuplente() ) {
				$suplentes[] = $miembroEquipoPartido;
			}
		}

		return $suplentes;

	}

	public function __construct() {
		$this->miembroEquipoPartidos = new ArrayCollection();
	}

	public function getId() {
		return $this->id;
	}

	public function getFechaConfirmacion(): ?\DateTimeInterface {
		return $this->fechaConfirmacion;
	}

	public function setFechaConfirmacion( ?\DateTimeInterface $fechaConfirmacion ): self {
		$this->fechaConfirmacion = $fechaConfirmacion;

		return $this;
	}

	public function getEstado(): ?string {
		return $this->estado;
	}

	public function setEstado( ?string $estado ): self {
		$this->estado = $estado;

		return $this;
	}

	/**
	 * @return Collection|MiembroEquipoPartido[]
	 */
	public function getMiembroEquipoPartidos(): Collection {
		return $this->miembroEquipoPartidos;
	}

	public function addMiembroEquipoPartido( MiembroEquipoPartido $miembroEquipoPartido ): self {
		if ( ! $this->miembroEquipoPartidos->contains( $miembroEquipoPartido ) ) {
			$this->miembroEquipoPartidos[] = $miembroEquipoPartido;
			$miembroEquipoPartido->setEquipoPartido( $this );
		}

		return $this;
	}

	public function removeMiembroEquipoPartido( MiembroEquipoPartido $miembroEquipoPartido ): self {
		if ( $this->miembroEquipoPartidos->contains( $miembroEquipoPartido ) ) {
			$this->miembroEquipoPartidos->removeElement( $miembroEquipoPartido );
			// set the owning side to null (unless already changed)
			if ( $miembroEquipoPartido->getEquipoPartido() === $this ) {
				$miembroEquipoPartido->setEquipoPartido( null );
			}
		}

		return $this;
	}

	public function getLocal(): ?bool {
		return $this->local;
	}

	public function setLocal( ?bool $local ): self {
		$this->local = $local;

		return $this;
	}

	public function getVisitante(): ?bool {
		return $this->visitante;
	}

	public function setVisitante( ?bool $visitante ): self {
		$this->visitante = $visitante;

		return $this;
	}

	public function getEquipo(): ?ParticipanteTorneo {
		return $this->equipo;
	}

	public function setEquipo( ?ParticipanteTorneo $equipo ): self {
		$this->equipo = $equipo;

		return $this;
	}

	public function getPartido(): ?Partido {
		return $this->partido;
	}

	public function setPartido( ?Partido $partido ): self {
		$this->partido = $partido;

		return $this;
	}
}
