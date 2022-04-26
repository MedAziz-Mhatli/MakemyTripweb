<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vol
 *
 * @ORM\Table(name="vol")
 * @ORM\Entity
 */
class Vol
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_vol", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idVol;

    /**
     * @var string
     *
     * @ORM\Column(name="départ", type="string", length=255, nullable=false)
     */
    private $d�part;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=255, nullable=false)
     */
    private $destination;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_départ", type="date", nullable=false)
     */
    private $dateD�part;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_retour", type="date", nullable=false)
     */
    private $dateRetour;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_escales", type="integer", nullable=false)
     */
    private $nbEscales;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @return int
     */
    public function getIdVol()
    {
        return $this->idVol;
    }

    /**
     * @param int $idVol
     */
    public function setIdVol(int $idVol): void
    {
        $this->idVol = $idVol;
    }

    /**
     * @return string
     */
    public function getD�part()
    {
        return $this->d�part;
    }

    /**
     * @param string $d�part
     */
    public function setD�part(string $d�part): void
    {
        $this->d�part = $d�part;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     */
    public function setDestination(string $destination): void
    {
        $this->destination = $destination;
    }

    /**
     * @return \DateTime
     */
    public function getDateD�part()
    {
        return $this->dateD�part;
    }

    /**
     * @param \DateTime $dateD�part
     */
    public function setDateD�part(\DateTime $dateD�part): void
    {
        $this->dateD�part = $dateD�part;
    }

    /**
     * @return \DateTime
     */
    public function getDateRetour()
    {
        return $this->dateRetour;
    }

    /**
     * @param \DateTime $dateRetour
     */
    public function setDateRetour(\DateTime $dateRetour): void
    {
        $this->dateRetour = $dateRetour;
    }

    /**
     * @return int
     */
    public function getNbEscales()
    {
        return $this->nbEscales;
    }

    /**
     * @param int $nbEscales
     */
    public function setNbEscales(int $nbEscales): void
    {
        $this->nbEscales = $nbEscales;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }


}
