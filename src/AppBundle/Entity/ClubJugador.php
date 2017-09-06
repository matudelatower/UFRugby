<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClubJugador
 *
 * @ORM\Table(name="club_jugador")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClubJugadorRepository")
 */
class ClubJugador
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
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Club", inversedBy="jugador", cascade={"persist"})
	 * @ORM\JoinColumn(name="club_id", referencedColumnName="id")
	 */
	private $club;

	/**
	 * @var
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Jugador", inversedBy="club", cascade={"persist"})
	 * @ORM\JoinColumn(name="jugador_id", referencedColumnName="id")
	 */
	private $jugador;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set club
     *
     * @param \AppBundle\Entity\Club $club
     *
     * @return ClubJugador
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

    /**
     * Set jugador
     *
     * @param \AppBundle\Entity\Jugador $jugador
     *
     * @return ClubJugador
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
}
