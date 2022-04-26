<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReservationChambre
 *
 * @ORM\Table(name="reservation_chambre", indexes={@ORM\Index(name="id_client", columns={"id_client"}), @ORM\Index(name="id_chambre", columns={"id_chambre"}), @ORM\Index(name="id_facture", columns={"id_facture"})})
 * @ORM\Entity
 */
class ReservationChambre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_resChambre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReschambre;

    /**
     * @var int
     *
     * @ORM\Column(name="duree_reservation", type="integer", nullable=false)
     */
    private $dureeReservation;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_personnes", type="integer", nullable=false)
     */
    private $nbPersonnes;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie_personne", type="string", length=0, nullable=false)
     */
    private $categoriePersonne;

    /**
     * @var \Chambre
     *
     * @ORM\ManyToOne(targetEntity="Chambre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_chambre", referencedColumnName="id_chambre")
     * })
     */
    private $idChambre;

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
