<?php

namespace App\Entity;

use App\Entity\Base\BaseClass;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="App\Repository\TorneoRepository")
 */
class Torneo extends BaseClass {
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

	/**
	 * @ORM\Column(type="integer")
	 */
	private $maximoTitularesPorEquipo;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $maximoSuplentesPorEquipo;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $cargaIncidencias;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\ParticipanteTorneo", mappedBy="torneo", orphanRemoval=true, cascade={"persist"})
	 */
	private $participanteTorneos;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $sexo;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Club")
	 */
	private $clubOrganizador;


	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Division")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $division;

	/**
	 * NOTE: This is not a mapped field of entity metadata, just a simple property.
	 *
	 * @Vich\UploadableField(mapping="torneo_image", fileNameProperty="imageName")
	 *
	 * @var File
	 *
	 * @Assert\File(mimeTypes={ "image/*" })
	 */
	private $imageFile;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 *
	 * @var string
	 *
	 */
	private $imageName;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\RondaTorneo", mappedBy="torneo")
	 */
	private $rondaTorneos;


	/**
	 * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
	 * of 'UploadedFile' is injected into this setter to trigger the  update. If this
	 * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
	 * must be able to accept an instance of 'File' as the bundle will inject one here
	 * during Doctrine hydration.
	 *
	 * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
	 *
	 * @return Torneo
	 */
	public function setImageFile( File $image = null ) {
		$this->imageFile = $image;
		if ( $image ) {
			// It is required that at least one field changes if you are using doctrine
			// otherwise the event listeners won't be called and the file is lost
			$this->fechaActualizacion = new \DateTime( 'now' );
		}

		return $this;
	}

	/**
	 * @return File
	 */
	public function getImageFile() {
		return $this->imageFile;
	}

	/**
	 * @param string $imageName
	 *
	 * @return Torneo
	 */
	public function setImageName( $imageName ) {
		$this->imageName = $imageName;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getImageName() {
		return $this->imageName;
	}

	public function __toString() {
		return $this->nombre;
	}

	public function __construct() {
		$this->participanteTorneos = new ArrayCollection();
		$this->rondaTorneos        = new ArrayCollection();
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

	public function getMaximoTitularesPorEquipo(): ?int {
		return $this->maximoTitularesPorEquipo;
	}

	public function setMaximoTitularesPorEquipo( int $maximoTitularesPorEquipo ): self {
		$this->maximoTitularesPorEquipo = $maximoTitularesPorEquipo;

		return $this;
	}

	public function getMaximoSuplentesPorEquipo(): ?int {
		return $this->maximoSuplentesPorEquipo;
	}

	public function setMaximoSuplentesPorEquipo( int $maximoSuplentesPorEquipo ): self {
		$this->maximoSuplentesPorEquipo = $maximoSuplentesPorEquipo;

		return $this;
	}

	public function getCargaIncidencias(): ?string {
		return $this->cargaIncidencias;
	}

	public function setCargaIncidencias( string $cargaIncidencias ): self {
		$this->cargaIncidencias = $cargaIncidencias;

		return $this;
	}

	/**
	 * @return Collection|ParticipanteTorneo[]
	 */
	public function getParticipanteTorneos(): Collection {
		return $this->participanteTorneos;
	}

	public function addParticipanteTorneo( ParticipanteTorneo $participanteTorneo ): self {
		if ( ! $this->participanteTorneos->contains( $participanteTorneo ) ) {
			$this->participanteTorneos[] = $participanteTorneo;
			$participanteTorneo->setTorneo( $this );
		}

		return $this;
	}

	public function removeParticipanteTorneo( ParticipanteTorneo $participanteTorneo ): self {
		if ( $this->participanteTorneos->contains( $participanteTorneo ) ) {
			$this->participanteTorneos->removeElement( $participanteTorneo );
			// set the owning side to null (unless already changed)
			if ( $participanteTorneo->getTorneo() === $this ) {
				$participanteTorneo->setTorneo( null );
			}
		}

		return $this;
	}

	public function getSexo(): ?string {
		return $this->sexo;
	}

	public function setSexo( string $sexo ): self {
		$this->sexo = $sexo;

		return $this;
	}

	public function getClubOrganizador(): ?Club {
		return $this->clubOrganizador;
	}

	public function setClubOrganizador( ?Club $clubOrganizador ): self {
		$this->clubOrganizador = $clubOrganizador;

		return $this;
	}

	public function getDivision(): ?Division {
		return $this->division;
	}

	public function setDivision( ?Division $division ): self {
		$this->division = $division;

		return $this;
	}

	/**
	 * @return Collection|RondaTorneo[]
	 */
	public function getRondaTorneos(): Collection {
		return $this->rondaTorneos;
	}

	public function addRondaTorneo( RondaTorneo $rondaTorneo ): self {
		if ( ! $this->rondaTorneos->contains( $rondaTorneo ) ) {
			$this->rondaTorneos[] = $rondaTorneo;
			$rondaTorneo->setTorneo( $this );
		}

		return $this;
	}

	public function removeRondaTorneo( RondaTorneo $rondaTorneo ): self {
		if ( $this->rondaTorneos->contains( $rondaTorneo ) ) {
			$this->rondaTorneos->removeElement( $rondaTorneo );
			// set the owning side to null (unless already changed)
			if ( $rondaTorneo->getTorneo() === $this ) {
				$rondaTorneo->setTorneo( null );
			}
		}

		return $this;
	}
}
