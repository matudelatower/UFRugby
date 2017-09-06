<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Base\BaseClass;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Club
 *
 * @Vich\Uploadable
 * @ORM\Table(name="club")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClubRepository")
 */
class Club extends BaseClass
{
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
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Sede", mappedBy="club", cascade={"persist", "remove"})
	 */
	private $sede;

	/**
	 * @var
	 *
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\Contacto", cascade={"persist"})
	 * @ORM\JoinColumn(name="contacto_id", referencedColumnName="id")
	 */
	private $contacto;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categoria")
	 * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
	 */
	private $categoria;

	/**
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\ClubJugador", mappedBy="club", cascade={"persist", "remove"})
	 */
	private $jugador;


	/**
	 * NOTE: This is not a mapped field of entity metadata, just a simple property.
	 *
	 * @Vich\UploadableField(mapping="club_image", fileNameProperty="imageName")
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
		return $this->nombre;
	}


	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sede = new \Doctrine\Common\Collections\ArrayCollection();
        $this->jugador = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Club
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Club
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
     * @return Club
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    /**
     * Add sede
     *
     * @param \AppBundle\Entity\Sede $sede
     *
     * @return Club
     */
    public function addSede(\AppBundle\Entity\Sede $sede)
    {
        $this->sede[] = $sede;

        return $this;
    }

    /**
     * Remove sede
     *
     * @param \AppBundle\Entity\Sede $sede
     */
    public function removeSede(\AppBundle\Entity\Sede $sede)
    {
        $this->sede->removeElement($sede);
    }

    /**
     * Get sede
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSede()
    {
        return $this->sede;
    }

    /**
     * Set contacto
     *
     * @param \AppBundle\Entity\Contacto $contacto
     *
     * @return Club
     */
    public function setContacto(\AppBundle\Entity\Contacto $contacto = null)
    {
        $this->contacto = $contacto;

        return $this;
    }

    /**
     * Get contacto
     *
     * @return \AppBundle\Entity\Contacto
     */
    public function getContacto()
    {
        return $this->contacto;
    }

    /**
     * Set categoria
     *
     * @param \AppBundle\Entity\Categoria $categoria
     *
     * @return Club
     */
    public function setCategoria(\AppBundle\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \AppBundle\Entity\Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Add jugador
     *
     * @param \AppBundle\Entity\ClubJugador $jugador
     *
     * @return Club
     */
    public function addJugador(\AppBundle\Entity\ClubJugador $jugador)
    {
        $this->jugador[] = $jugador;

        return $this;
    }

    /**
     * Remove jugador
     *
     * @param \AppBundle\Entity\ClubJugador $jugador
     */
    public function removeJugador(\AppBundle\Entity\ClubJugador $jugador)
    {
        $this->jugador->removeElement($jugador);
    }

    /**
     * Get jugador
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJugador()
    {
        return $this->jugador;
    }

    /**
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return Club
     */
    public function setCreadoPor(\UsuariosBundle\Entity\Usuario $creadoPor = null)
    {
        $this->creadoPor = $creadoPor;

        return $this;
    }

    /**
     * Set actualizadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $actualizadoPor
     *
     * @return Club
     */
    public function setActualizadoPor(\UsuariosBundle\Entity\Usuario $actualizadoPor = null)
    {
        $this->actualizadoPor = $actualizadoPor;

        return $this;
    }
}
