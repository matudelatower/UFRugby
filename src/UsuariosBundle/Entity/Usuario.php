<?php

namespace UsuariosBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class Usuario extends BaseUser {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Persona")
	 * @ORM\JoinColumn(name="persona_id", referencedColumnName="id", nullable=true)
	 */
	private $persona;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Club")
	 * @ORM\JoinColumn(name="club_id", referencedColumnName="id", nullable=true)
	 */
	private $club;


	public function __construct() {
		parent::__construct();
		// your own logic
	}


    /**
     * Set persona
     *
     * @param \AppBundle\Entity\Persona $persona
     *
     * @return Usuario
     */
    public function setPersona(\AppBundle\Entity\Persona $persona = null)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \AppBundle\Entity\Persona
     */
    public function getPersona()
    {
        return $this->persona;
    }

    /**
     * Set club
     *
     * @param \AppBundle\Entity\Club $club
     *
     * @return Usuario
     */
    public function setClub(\AppBundle\Entity\Club $club = null)
    {
        $this->club = $club;

        return $this;
    }

    /**
     * Get club
     *
     * @return \AppBundle\Entity\Club
     */
    public function getClub()
    {
        return $this->club;
    }
}
