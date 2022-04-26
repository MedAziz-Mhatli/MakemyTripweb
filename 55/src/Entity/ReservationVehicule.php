<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReservationVehicule
 *
 * @ORM\Table(name="reservation_vehicule", indexes={@ORM\Index(name="id_client", columns={"id_client"}), @ORM\Index(name="id_vehicule", columns={"id_vehicule"}), @ORM\Index(name="id_facture", columns={"id_facture"})})
 * @ORM\Entity
 */
class ReservationVehicule
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_resVehicule", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idResvehicule;

    /**
     * @var int
     *
     * @ORM\Column(name="id_chauffeur", type="integer", nullable=false)
     */
    private $idChauffeur;

    /**
     * @var int
     *
     * @ORM\Column(name="duree_location", type="integer", nullable=false)
     */
    private $dureeLocation;

    /**
     * @var \Vehicule
     *
     * @ORM\ManyToOne(targetEntity="Vehicule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_vehicule", referencedColumnName="id_vehicule")
     * })
     */
    private $idVehicule;

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
     * @var \Facture
     *
     * @ORM\ManyToOne(targetEntity="Facture")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_facture", referencedColumnName="id_facture")
     * })
     */
    private $idFacture;


}
