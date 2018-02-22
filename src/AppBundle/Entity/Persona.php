<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Base\BaseClass;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Persona
 *
 * @Vich\Uploadable
 * @ORM\Table(name="persona")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonaRepository")
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
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoIdentificacion")
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
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\Jugador", mappedBy="persona", cascade={"persist", "remove"})
	 */
	private $jugador;

	/**
	 * @var
	 *
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\Contacto", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(name="contacto_id", referencedColumnName="id")
	 */
	private $contacto;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sexo")
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
	 * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
	 * of 'UploadedFile' is injected into this setter to trigger the  update. If this
	 * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
	 * must be able to accept an instance of 'File' as the bundle will inject one here
	 * during Doctrine hydration.
	 *
	 * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
	 *
	 * @return Product
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
	 * @param \AppBundle\Entity\TipoIdentificacion $tipoIdentificacion
	 *
	 * @return Persona
	 */
	public function setTipoIdentificacion( \AppBundle\Entity\TipoIdentificacion $tipoIdentificacion = null ) {
		$this->tipoIdentificacion = $tipoIdentificacion;

		return $this;
	}

	/**
	 * Get tipoIdentificacion
	 *
	 * @return \AppBundle\Entity\TipoIdentificacion
	 */
	public function getTipoIdentificacion() {
		return $this->tipoIdentificacion;
	}

	/**
	 * Set jugador
	 *
	 * @param \AppBundle\Entity\Jugador $jugador
	 *
	 * @return Persona
	 */
	public function setJugador( \AppBundle\Entity\Jugador $jugador = null ) {
		$this->jugador = $jugador;

		return $this;
	}

	/**
	 * Get jugador
	 *
	 * @return \AppBundle\Entity\Jugador
	 */
	public function getJugador() {
		return $this->jugador;
	}

	/**
	 * Set contacto
	 *
	 * @param \AppBundle\Entity\Contacto $contacto
	 *
	 * @return Persona
	 */
	public function setContacto( \AppBundle\Entity\Contacto $contacto = null ) {
		$this->contacto = $contacto;

		return $this;
	}

	/**
	 * Get contacto
	 *
	 * @return \AppBundle\Entity\Contacto
	 */
	public function getContacto() {
		return $this->contacto;
	}

	/**
	 * Set sexo
	 *
	 * @param \AppBundle\Entity\Sexo $sexo
	 *
	 * @return Persona
	 */
	public function setSexo( \AppBundle\Entity\Sexo $sexo = null ) {
		$this->sexo = $sexo;

		return $this;
	}

	/**
	 * Get sexo
	 *
	 * @return \AppBundle\Entity\Sexo
	 */
	public function getSexo() {
		return $this->sexo;
	}

	/**
	 * Set creadoPor
	 *
	 * @param \UsuariosBundle\Entity\Usuario $creadoPor
	 *
	 * @return Persona
	 */
	public function setCreadoPor( \UsuariosBundle\Entity\Usuario $creadoPor = null ) {
		$this->creadoPor = $creadoPor;

		return $this;
	}

	/**
	 * Set actualizadoPor
	 *
	 * @param \UsuariosBundle\Entity\Usuario $actualizadoPor
	 *
	 * @return Persona
	 */
	public function setActualizadoPor( \UsuariosBundle\Entity\Usuario $actualizadoPor = null ) {
		$this->actualizadoPor = $actualizadoPor;

		return $this;
	}
}
