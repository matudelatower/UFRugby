<?php

namespace App\Entity;

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
	 * @ORM\ManyToOne(targetEntity="App\Entity\Persona")
	 * @ORM\JoinColumn(name="persona_id", referencedColumnName="id", nullable=true)
	 */
	private $persona;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\Club")
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
     * @param \App\Entity\Persona $persona
     *
     * @return Usuario
     */
    public function setPersona(\App\Entity\Persona $persona = null)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \App\Entity\Persona
     */
    public function getPersona()
    {
        return $this->persona;
    }

    /**
     * Set club
     *
     * @param \App\Entity\Club $club
     *
     * @return Usuario
     */
    public function setClub(\App\Entity\Club $club = null)
    {
        $this->club = $club;

        return $this;
    }

    /**
     * Get club
     *
     * @return \App\Entity\Club
     */
    public function getClub()
    {
        return $this->club;
    }
}
