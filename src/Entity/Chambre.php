<?php

namespace App\Entity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Chambre
 *
 * @ORM\Table(name="chambre", indexes={@ORM\Index(name="chambre_ibfk_1", columns={"id_hotel"})})
 * @ORM\Entity
 */
class Chambre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_chambre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idChambre;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="vue", type="string", length=255, nullable=false)
     */
    private $vue;

    /**
     * @var float
     * @Assert\NotBlank(message="Prix doit etre non vide")
     *
     * @ORM\Column(name="prix_nuitee", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixNuitee;

    /**
     * @var \Hotel
     *
     * @ORM\ManyToOne(targetEntity="Hotel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_hotel", referencedColumnName="id_hotel")
     * })
     */
    // private $idHotel;

    /* /**
      * @ORM\ManyToOne(targetEntity=Hotel::class, inversedBy="chambres")
      */
    private $hotel;

    public function getIdChambre(): ?int
    {
        return $this->idChambre;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getVue(): ?string
    {
        return $this->vue;
    }

    public function setVue(string $vue): self
    {
        $this->vue = $vue;

        return $this;
    }

    public function getPrixNuitee(): ?float
    {
        return $this->prixNuitee;
    }

    public function setPrixNuitee(float $prixNuitee): self
    {
        $this->prixNuitee = $prixNuitee;

        return $this;
    }

    /*public function getIdHotel(): ?Hotel
    {
        return $this->idHotel;
    }

    public function setIdHotel(?Hotel $idHotel): self
    {
        $this->idHotel = $idHotel;

        return $this;
    }*/

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }

}
