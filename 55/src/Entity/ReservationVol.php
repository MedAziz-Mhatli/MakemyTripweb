<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReservationVol
 *
 * @ORM\Table(name="reservation_vol", indexes={@ORM\Index(name="id_vol", columns={"id_vol"}), @ORM\Index(name="id_client", columns={"id_client"}), @ORM\Index(name="id_facture", columns={"id_facture"})})
 * @ORM\Entity
 */
class ReservationVol
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_resVol", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idResvol;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_resVol", type="date", nullable=false)
     */
    private $dateResvol;

    /**
     * @var string
     *
     * @ORM\Column(name="compagnie_aerienne", type="string", length=0, nullable=false)
     */
    private $compagnieAerienne;

    /**
     * @var string
     *
     * @ORM\Column(name="classe", type="string", length=0, nullable=false)
     */
    private $classe;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_personnes", type="integer", nullable=false)
     */
    private $nbPersonnes;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id_client")
     * })
     */
    private $idClient;

    /**
     * @var \Vol
     *
     * @ORM\ManyToOne(targetEntity="Vol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_vol", referencedColumnName="id_vol")
     * })
     */
    private $idVol;

    /**
     * @var \Facture
     *
     * @ORM\ManyToOne(targetEntity="Facture")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_facture", referencedColumnName="id_facture")
     * })
     */
    private $idFacture;

    /**
     * @return int
     */
    public function getIdResvol()
    {
        return $this->idResvol;
    }

    /**
     * @param int $idResvol
     */
    public function setIdResvol(int $idResvol): void
    {
        $this->idResvol = $idResvol;
    }

    /**
     * @return \DateTime
     */
    public function getDateResvol()
    {
        return $this->dateResvol;
    }

    /**
     * @param \DateTime $dateResvol
     */
    public function setDateResvol(\DateTime $dateResvol): void
    {
        $this->dateResvol = $dateResvol;
    }

    /**
     * @return string
     */
    public function getCompagnieAerienne()
    {
        return $this->compagnieAerienne;
    }

    /**
     * @param string $compagnieAerienne
     */
    public function setCompagnieAerienne(string $compagnieAerienne): void
    {
        $this->compagnieAerienne = $compagnieAerienne;
    }

    /**
     * @return string
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * @param string $classe
     */
    public function setClasse(string $classe): void
    {
        $this->classe = $classe;
    }

    /**
     * @return int
     */
    public function getNbPersonnes()
    {
        return $this->nbPersonnes;
    }

    /**
     * @param int $nbPersonnes
     */
    public function setNbPersonnes(int $nbPersonnes): void
    {
        $this->nbPersonnes = $nbPersonnes;
    }

    /**
     * @return \Client
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * @param \Client $idClient
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;
    }

    /**
     * @return \Vol
     */
    public function getIdVol()
    {
        return $this->idVol;
    }

    /**
     * @param \Vol $idVol
     */
    public function setIdVol( $idVol): void
    {
        $this->idVol = $idVol;
    }

    /**
     * @return \Facture
     */
    public function getIdFacture()
    {
        return $this->idFacture;
    }

    /**
     * @param \Facture $idFacture
     */
    public function setIdFacture( $idFacture): void
    {
        $this->idFacture = $idFacture;
    }


}
