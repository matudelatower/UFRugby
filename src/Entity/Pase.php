<?php

namespace App\Entity;

use App\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaseRepository")
 *
 */
class Pase extends BaseClass {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $observacion;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $fechaConfirmacionClub;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $fechaConfirmacionUnion;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $confirmacionUnion;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $confirmacionClub;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $estado;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $motivoRechazo;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Club")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $clubOrigen;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Club")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $clubDestino;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Jugador", inversedBy="pases")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $jugador;


	public function getId() {
		return $this->id;
	}

	public function getObservacion(): ?string {
		return $this->observacion;
	}

	public function setObservacion( ?string $observacion ): self {
		$this->observacion = $observacion;

		return $this;
	}

	public function getFechaConfirmacionClub(): ?\DateTimeInterface {
		return $this->fechaConfirmacionClub;
	}

	public function setFechaConfirmacionClub( ?\DateTimeInterface $fechaConfirmacionClub ): self {
		$this->fechaConfirmacionClub = $fechaConfirmacionClub;

		return $this;
	}

	public function getFechaConfirmacionUnion(): ?\DateTimeInterface {
		return $this->fechaConfirmacionUnion;
	}

	public function setFechaConfirmacionUnion( ?\DateTimeInterface $fechaConfirmacionUnion ): self {
		$this->fechaConfirmacionUnion = $fechaConfirmacionUnion;

		return $this;
	}

	public function getConfirmacionUnion(): ?bool {
		return $this->confirmacionUnion;
	}

	public function setConfirmacionUnion( ?bool $confirmacionUnion ): self {
		$this->confirmacionUnion = $confirmacionUnion;

		return $this;
	}

	public function getConfirmacionClub(): ?bool {
		return $this->confirmacionClub;
	}

	public function setConfirmacionClub( ?bool $confirmacionClub ): self {
		$this->confirmacionClub = $confirmacionClub;

		return $this;
	}

	public function getEstado(): ?string {
		return $this->estado;
	}

	public function setEstado( string $estado ): self {
		$this->estado = $estado;

		return $this;
	}

	public function getMotivoRechazo(): ?string {
		return $this->motivoRechazo;
	}

	public function setMotivoRechazo( ?string $motivoRechazo ): self {
		$this->motivoRechazo = $motivoRechazo;

		return $this;
	}

	public function getClubOrigen(): ?Club {
		return $this->clubOrigen;
	}

	public function setClubOrigen( ?Club $clubOrigen ): self {
		$this->clubOrigen = $clubOrigen;

		return $this;
	}

	public function getClubDestino(): ?Club {
		return $this->clubDestino;
	}

	public function setClubDestino( ?Club $clubDestino ): self {
		$this->clubDestino = $clubDestino;

		return $this;
	}

	public function getJugador(): ?Jugador {
		return $this->jugador;
	}

	public function setJugador( ?Jugador $jugador ): self {
		$this->jugador = $jugador;

		return $this;
	}
}
