<?php

namespace App\Entity;

use App\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TipoSeleccionRepository")
 */
class TipoSeleccion extends BaseClass {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $nombre;

	public function __toString(): ?string {
		return $this->nombre;
	}

	public function getId() {
		return $this->id;
	}

	public function getNombre(): ?string {
		return $this->nombre;
	}

	public function setNombre( string $nombre ): self {
		$this->nombre = $nombre;

		return $this;
	}
}
