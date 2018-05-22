<?php

namespace App\Entity;

use App\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="App\Repository\ConfiguracionRepository")
 */
class Configuracion extends BaseClass
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombreUnion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $siglas;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="union_image", fileNameProperty="imageName")
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
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->fechaActualizacion = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Product
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombreUnion(): ?string
    {
        return $this->nombreUnion;
    }

    public function setNombreUnion(string $nombreUnion): self
    {
        $this->nombreUnion = $nombreUnion;

        return $this;
    }

    public function getSiglas(): ?string
    {
        return $this->siglas;
    }

    public function setSiglas(string $siglas): self
    {
        $this->siglas = $siglas;

        return $this;
    }
}
