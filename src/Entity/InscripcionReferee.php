<?php

namespace App\Entity;

use App\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InscripcionRefereeRepository")
 */
class InscripcionReferee extends BaseClass
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $anio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tokenConfirmacion;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $confirmado;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $confirmadoUnion;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fechaConfirmacionUnion;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\Referee", inversedBy="inscripcionReferee", cascade={"persist"})
	 * @ORM\JoinColumn(name="referee_id", referencedColumnName="id")
	 */
	private $referee;

    public function getId()
    {
        return $this->id;
    }

    public function getAnio(): ?int
    {
        return $this->anio;
    }

    public function setAnio(int $anio): self
    {
        $this->anio = $anio;

        return $this;
    }

    public function getTokenConfirmacion(): ?string
    {
        return $this->tokenConfirmacion;
    }

    public function setTokenConfirmacion(?string $tokenConfirmacion): self
    {
        $this->tokenConfirmacion = $tokenConfirmacion;

        return $this;
    }

    public function getConfirmado(): ?bool
    {
        return $this->confirmado;
    }

    public function setConfirmado(?bool $confirmado): self
    {
        $this->confirmado = $confirmado;

        return $this;
    }

    public function getConfirmadoUnion(): ?bool
    {
        return $this->confirmadoUnion;
    }

    public function setConfirmadoUnion(?bool $confirmadoUnion): self
    {
        $this->confirmadoUnion = $confirmadoUnion;

        return $this;
    }

    public function getFechaConfirmacionUnion(): ?\DateTimeInterface
    {
        return $this->fechaConfirmacionUnion;
    }

    public function setFechaConfirmacionUnion(?\DateTimeInterface $fechaConfirmacionUnion): self
    {
        $this->fechaConfirmacionUnion = $fechaConfirmacionUnion;

        return $this;
    }

    public function getReferee(): ?Referee
    {
        return $this->referee;
    }

    public function setReferee(?Referee $referee): self
    {
        $this->referee = $referee;

        return $this;
    }


}
