<?php

namespace App\Entity;

use App\Entity\Base\BaseClass;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RondaTorneoRepository")
 */
class RondaTorneo extends BaseClass
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
    private $nombre;

    /**
     * @ORM\Column(type="integer")
     */
    private $puntosGanado;

    /**
     * @ORM\Column(type="integer")
     */
    private $puntosPerdido;

    /**
     * @ORM\Column(type="integer")
     */
    private $puntosEmpatado;

    /**
     * @ORM\Column(type="integer")
     */
    private $puntosPorWalkover;

    /**
     * @ORM\Column(type="integer")
     */
    private $tantosPorWalkover;

    /**
     * @ORM\Column(type="integer")
     */
    private $bonusTriunfoCantidadTriesMayorA;

    /**
     * @ORM\Column(type="integer")
     */
    private $bonusTriunfoDiferenciaTriesMayorA;

    /**
     * @ORM\Column(type="integer")
     */
    private $bonusDerrotaDiferenciaPuntos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FechaRonda", mappedBy="ronda", orphanRemoval=true)
     */
    private $fechaRondas;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Torneo", inversedBy="rondaTorneos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $torneo;

	public function __toString() {
		return $this->nombre;
	}

    public function __construct()
    {
        $this->fechaRondas = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPuntosGanado(): ?int
    {
        return $this->puntosGanado;
    }

    public function setPuntosGanado(int $puntosGanado): self
    {
        $this->puntosGanado = $puntosGanado;

        return $this;
    }

    public function getPuntosPerdido(): ?int
    {
        return $this->puntosPerdido;
    }

    public function setPuntosPerdido(int $puntosPerdido): self
    {
        $this->puntosPerdido = $puntosPerdido;

        return $this;
    }

    public function getPuntosEmpatado(): ?int
    {
        return $this->puntosEmpatado;
    }

    public function setPuntosEmpatado(int $puntosEmpatado): self
    {
        $this->puntosEmpatado = $puntosEmpatado;

        return $this;
    }

    public function getPuntosPorWalkover(): ?int
    {
        return $this->puntosPorWalkover;
    }

    public function setPuntosPorWalkover(int $puntosPorWalkover): self
    {
        $this->puntosPorWalkover = $puntosPorWalkover;

        return $this;
    }

    public function getTantosPorWalkover(): ?int
    {
        return $this->tantosPorWalkover;
    }

    public function setTantosPorWalkover(int $tantosPorWalkover): self
    {
        $this->tantosPorWalkover = $tantosPorWalkover;

        return $this;
    }

    public function getBonusTriunfoCantidadTriesMayorA(): ?int
    {
        return $this->bonusTriunfoCantidadTriesMayorA;
    }

    public function setBonusTriunfoCantidadTriesMayorA(int $bonusTriunfoCantidadTriesMayorA): self
    {
        $this->bonusTriunfoCantidadTriesMayorA = $bonusTriunfoCantidadTriesMayorA;

        return $this;
    }

    public function getBonusTriunfoDiferenciaTriesMayorA(): ?int
    {
        return $this->bonusTriunfoDiferenciaTriesMayorA;
    }

    public function setBonusTriunfoDiferenciaTriesMayorA(int $bonusTriunfoDiferenciaTriesMayorA): self
    {
        $this->bonusTriunfoDiferenciaTriesMayorA = $bonusTriunfoDiferenciaTriesMayorA;

        return $this;
    }

    public function getBonusDerrotaDiferenciaPuntos(): ?int
    {
        return $this->bonusDerrotaDiferenciaPuntos;
    }

    public function setBonusDerrotaDiferenciaPuntos(int $bonusDerrotaDiferenciaPuntos): self
    {
        $this->bonusDerrotaDiferenciaPuntos = $bonusDerrotaDiferenciaPuntos;

        return $this;
    }

    /**
     * @return Collection|FechaRonda[]
     */
    public function getFechaRondas(): Collection
    {
        return $this->fechaRondas;
    }

    public function addFechaRonda(FechaRonda $fechaRonda): self
    {
        if (!$this->fechaRondas->contains($fechaRonda)) {
            $this->fechaRondas[] = $fechaRonda;
            $fechaRonda->setRonda($this);
        }

        return $this;
    }

    public function removeFechaRonda(FechaRonda $fechaRonda): self
    {
        if ($this->fechaRondas->contains($fechaRonda)) {
            $this->fechaRondas->removeElement($fechaRonda);
            // set the owning side to null (unless already changed)
            if ($fechaRonda->getRonda() === $this) {
                $fechaRonda->setRonda(null);
            }
        }

        return $this;
    }

    public function getTorneo(): ?Torneo
    {
        return $this->torneo;
    }

    public function setTorneo(?Torneo $torneo): self
    {
        $this->torneo = $torneo;

        return $this;
    }
}
