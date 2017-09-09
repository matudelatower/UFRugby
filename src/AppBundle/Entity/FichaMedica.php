<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Base\BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * FichaMedica
 *
 * @ORM\Table(name="ficha_medica")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FichaMedicaRepository")
 */
class FichaMedica extends BaseClass
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
     * @ORM\Column(name="prestador", type="string", length=255, nullable=true)
     */
    private $prestador;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_afiliado", type="string", length=255, nullable=true)
     */
    private $numeroAfiliado;


    /**
     * @var string
     *
     * @ORM\Column(name="indice_torg", type="string", length=255)
     */
    private $indiceTorg;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Jugador", inversedBy="fichaMedica")
	 * @ORM\JoinColumn(name="jugador_id", referencedColumnName="id")
	 */
	private $jugador;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\GrupoSanguineo")
	 * @ORM\JoinColumn(name="grupo_sanguineo_id", referencedColumnName="id")
	 */
	private $grupoSanguineo;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="tiene_cobertura", type="boolean", nullable=true)
	 */
	private $tieneCobertura;
	

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
     * Set prestador
     *
     * @param string $prestador
     *
     * @return FichaMedica
     */
    public function setPrestador($prestador)
    {
        $this->prestador = $prestador;

        return $this;
    }

    /**
     * Get prestador
     *
     * @return string
     */
    public function getPrestador()
    {
        return $this->prestador;
    }

    /**
     * Set numeroAfiliado
     *
     * @param string $numeroAfiliado
     *
     * @return FichaMedica
     */
    public function setNumeroAfiliado($numeroAfiliado)
    {
        $this->numeroAfiliado = $numeroAfiliado;

        return $this;
    }

    /**
     * Get numeroAfiliado
     *
     * @return string
     */
    public function getNumeroAfiliado()
    {
        return $this->numeroAfiliado;
    }

    /**
     * Set indiceTorg
     *
     * @param string $indiceTorg
     *
     * @return FichaMedica
     */
    public function setIndiceTorg($indiceTorg)
    {
        $this->indiceTorg = $indiceTorg;

        return $this;
    }

    /**
     * Get indiceTorg
     *
     * @return string
     */
    public function getIndiceTorg()
    {
        return $this->indiceTorg;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return FichaMedica
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
     * @return FichaMedica
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    /**
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return FichaMedica
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
     * @return FichaMedica
     */
    public function setActualizadoPor(\UsuariosBundle\Entity\Usuario $actualizadoPor = null)
    {
        $this->actualizadoPor = $actualizadoPor;

        return $this;
    }

    /**
     * Set jugador
     *
     * @param \AppBundle\Entity\Jugador $jugador
     *
     * @return FichaMedica
     */
    public function setJugador(\AppBundle\Entity\Jugador $jugador = null)
    {
        $this->jugador = $jugador;

        return $this;
    }

    /**
     * Get jugador
     *
     * @return \AppBundle\Entity\Jugador
     */
    public function getJugador()
    {
        return $this->jugador;
    }

    /**
     * Set grupoSanguineo
     *
     * @param \AppBundle\Entity\GrupoSanguineo $grupoSanguineo
     *
     * @return FichaMedica
     */
    public function setGrupoSanguineo(\AppBundle\Entity\GrupoSanguineo $grupoSanguineo = null)
    {
        $this->grupoSanguineo = $grupoSanguineo;

        return $this;
    }

    /**
     * Get grupoSanguineo
     *
     * @return \AppBundle\Entity\GrupoSanguineo
     */
    public function getGrupoSanguineo()
    {
        return $this->grupoSanguineo;
    }

    /**
     * Set tieneCobertura
     *
     * @param boolean $tieneCobertura
     *
     * @return FichaMedica
     */
    public function setTieneCobertura($tieneCobertura)
    {
        $this->tieneCobertura = $tieneCobertura;

        return $this;
    }

    /**
     * Get tieneCobertura
     *
     * @return boolean
     */
    public function getTieneCobertura()
    {
        return $this->tieneCobertura;
    }
}
