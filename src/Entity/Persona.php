<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Base\BaseClass;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Persona
 *
 * @ApiResource()
 * @Vich\Uploadable
 * @ORM\Table(name="persona")
 * @ORM\Entity(repositoryClass="App\Repository\PersonaRepository")
 */
class Persona extends BaseClass {
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
	 * @ORM\Column(name="nombre", type="string", length=255)
	 */
	private $nombre;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="apellido", type="string", length=255)
	 */
	private $apellido;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\TipoIdentificacion")
	 * @ORM\JoinColumn(name="tipo_identificacion_id", referencedColumnName="id")
	 */
	private $tipoIdentificacion;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="numero_identificacion", type="string", length=255)
	 */
	private $numeroIdentificacion;

	/**
	 *
	 * @ORM\OneToMany(targetEntity="App\Entity\Jugador", mappedBy="persona", cascade={"persist", "remove"})
	 */
	private $jugador;

	/**
	 *
	 * @ORM\OneToMany(targetEntity="App\Entity\Referee", mappedBy="persona", cascade={"persist", "remove"})
	 */
	private $referee;

	/**
	 * @var
	 *
	 * @ORM\OneToOne(targetEntity="App\Entity\Contacto", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(name="contacto_id", referencedColumnName="id")
	 */
	private $contacto;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\Sexo")
	 * @ORM\JoinColumn(name="sexo_id", referencedColumnName="id")
	 */
	private $sexo;

	/**
	 * @var
	 * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
	 */
	private $fechaNacimiento;

	/**
	 * NOTE: This is not a mapped field of entity metadata, just a simple property.
	 *
	 * @Vich\UploadableField(mapping="persona_image", fileNameProperty="imageName")
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
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $identificacionFileName;

	/**
	 * NOTE: This is not a mapped field of entity metadata, just a simple property.
	 *
	 * @Vich\UploadableField(mapping="persona_identificacion", fileNameProperty="identificacionFileName")
	 *
	 * @var File
	 *
	 * @Assert\File(mimeTypes={ "image/*" })
	 */
	private $identificacionFile;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $identificacionVerificada;

	/**
	 * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
	 * of 'UploadedFile' is injected into this setter to trigger the  update. If this
	 * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
	 * must be able to accept an instance of 'File' as the bundle will inject one here
	 * during Doctrine hydration.
	 *
	 * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
	 *
	 * @return Persona
	 */
	public function setIdentificacionFile( File $image = null ) {
		$this->identificacionFile = $image;
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
	public function getIdentificacionFile() {
		return $this->identificacionFile;
	}

	/**
	 * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
	 * of 'UploadedFile' is injected into this setter to trigger the  update. If this
	 * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
	 * must be able to accept an instance of 'File' as the bundle will inject one here
	 * during Doctrine hydration.
	 *
	 * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
	 *
	 * @return Persona
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
	 * @return Product
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
		return $this->nombre . ' ' . $this->apellido;
	}

	public function __construct() {
		$this->jugador = new ArrayCollection();
		$this->referee = new ArrayCollection();
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
	 * Set nombre
	 *
	 * @param string $nombre
	 *
	 * @return Persona
	 */
	public function setNombre( $nombre ) {
		$this->nombre = $nombre;

		return $this;
	}

	/**
	 * Get nombre
	 *
	 * @return string
	 */
	public function getNombre() {
		return $this->nombre;
	}

	/**
	 * Set apellido
	 *
	 * @param string $apellido
	 *
	 * @return Persona
	 */
	public function setApellido( $apellido ) {
		$this->apellido = $apellido;

		return $this;
	}

	/**
	 * Get apellido
	 *
	 * @return string
	 */
	public function getApellido() {
		return $this->apellido;
	}

	/**
	 * Set numeroIdentificacion
	 *
	 * @param string $numeroIdentificacion
	 *
	 * @return Persona
	 */
	public function setNumeroIdentificacion( $numeroIdentificacion ) {
		$this->numeroIdentificacion = $numeroIdentificacion;

		return $this;
	}

	/**
	 * Get numeroIdentificacion
	 *
	 * @return string
	 */
	public function getNumeroIdentificacion() {
		return $this->numeroIdentificacion;
	}

	/**
	 * Set fechaNacimiento
	 *
	 * @param \DateTime $fechaNacimiento
	 *
	 * @return Persona
	 */
	public function setFechaNacimiento( $fechaNacimiento ) {
		$this->fechaNacimiento = $fechaNacimiento;

		return $this;
	}

	/**
	 * Get fechaNacimiento
	 *
	 * @return \DateTime
	 */
	public function getFechaNacimiento() {
		return $this->fechaNacimiento;
	}

	/**
	 * Set fechaCreacion
	 *
	 * @param \DateTime $fechaCreacion
	 *
	 * @return Persona
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
	 * @return Persona
	 */
	public function setFechaActualizacion( $fechaActualizacion ) {
		$this->fechaActualizacion = $fechaActualizacion;

		return $this;
	}

	/**
	 * Set tipoIdentificacion
	 *
	 * @param \App\Entity\TipoIdentificacion $tipoIdentificacion
	 *
	 * @return Persona
	 */
	public function setTipoIdentificacion( \App\Entity\TipoIdentificacion $tipoIdentificacion = null ) {
		$this->tipoIdentificacion = $tipoIdentificacion;

		return $this;
	}

	/**
	 * Get tipoIdentificacion
	 *
	 * @return \App\Entity\TipoIdentificacion
	 */
	public function getTipoIdentificacion() {
		return $this->tipoIdentificacion;
	}

	/**
	 * Set jugador
	 *
	 * @param \App\Entity\Jugador $jugador
	 *
	 * @return Persona
	 */
	public function setJugador( \App\Entity\Jugador $jugador = null ) {
		$this->jugador = $jugador;

		return $this;
	}

	public function addJugador( \App\Entity\Jugador $jugador ): self {
		if ( ! $this->jugador->contains( $jugador ) ) {
			$this->jugador[] = $jugador;
			$jugador->setPersona( $this );
		}

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
	 * Set contacto
	 *
	 * @param \App\Entity\Contacto $contacto
	 *
	 * @return Persona
	 */
	public function setContacto( \App\Entity\Contacto $contacto = null ) {
		$this->contacto = $contacto;

		return $this;
	}

	/**
	 * Get contacto
	 *
	 * @return \App\Entity\Contacto
	 */
	public function getContacto() {
		return $this->contacto;
	}

	/**
	 * Set sexo
	 *
	 * @param \App\Entity\Sexo $sexo
	 *
	 * @return Persona
	 */
	public function setSexo( \App\Entity\Sexo $sexo = null ) {
		$this->sexo = $sexo;

		return $this;
	}

	/**
	 * Get sexo
	 *
	 * @return \App\Entity\Sexo
	 */
	public function getSexo() {
		return $this->sexo;
	}

	/**
	 * Set creadoPor
	 *
	 * @param \App\Entity\Usuario $creadoPor
	 *
	 * @return Persona
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
	 * @return Persona
	 */
	public function setActualizadoPor( \App\Entity\Usuario $actualizadoPor = null ) {
		$this->actualizadoPor = $actualizadoPor;

		return $this;
	}

	/**
	 * Set referee
	 *
	 * @param \App\Entity\Referee $referee
	 *
	 * @return Persona
	 */
	public function setReferee( \App\Entity\Referee $referee = null ) {
		$this->referee = $referee;

		return $this;
	}

	public function addReferee( \App\Entity\Referee $referee ): self {
		if ( ! $this->referee->contains( $referee ) ) {
			$this->referee[] = $referee;
			$referee->setPersona( $this );
		}

		return $this;
	}

	/**
	 * Get referee
	 *
	 * @return \App\Entity\Referee
	 */
	public function getReferee() {
		return $this->referee;
	}

	public function getIdentificacionFileName(): ?string {
		return $this->identificacionFileName;
	}

	public function setIdentificacionFileName( ?string $identificacionFileName ): self {
		$this->identificacionFileName = $identificacionFileName;

		return $this;
	}

	public function getIdentificacionVerificada(): ?bool {
		return $this->identificacionVerificada;
	}

	public function setIdentificacionVerificada( ?bool $identificacionVerificada ): self {
		$this->identificacionVerificada = $identificacionVerificada;

		return $this;
	}
}
