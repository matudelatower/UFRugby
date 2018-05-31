<?php

namespace App\Entity;

use App\Entity\Base\BaseClass;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RefereeRepository")
 */
class Referee extends BaseClass
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\Persona", inversedBy="referee", cascade={"persist"})
	 * @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
	 */
	private $persona;

	/**
	 *
	 * @ORM\OneToMany(targetEntity="App\Entity\InscripcionReferee", mappedBy="referee", cascade={"persist", "remove"})
	 */
	private $inscripcionReferee;


	public function __construct()
	{
		$this->inscripcionReferee = new ArrayCollection();
	}


	public function getId()
    {
        return $this->id;
    }

    public function getPersona(): ?Persona
    {
        return $this->persona;
    }

    public function setPersona(?Persona $persona): self
    {
        $this->persona = $persona;

        return $this;
    }

	/**
	 * Set setInscripcionReferee
	 *
	 * @param \App\Entity\InscripcionReferee $inscripcionReferee
	 *
	 * @return Persona
	 */
	public function setInscripcionReferee( \App\Entity\InscripcionReferee $inscripcionReferee = null ) {
		$this->inscripcionReferee = $inscripcionReferee;

		return $this;
	}

	public function addInscripcionReferee(\App\Entity\InscripcionReferee $inscripcionReferee): self
	{
		if (!$this->inscripcionReferee->contains($inscripcionReferee)) {
			$this->inscripcionReferee[] = $inscripcionReferee;
			$inscripcionReferee->setReferee($this);
		}

		return $this;
	}

	/**
	 * @return Collection|InscripcionReferee[]
	 */
	public function getInscripcionReferee() {
		return $this->inscripcionReferee;
	}
}
