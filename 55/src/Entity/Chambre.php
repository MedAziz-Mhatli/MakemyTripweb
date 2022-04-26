<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chambre
 *
 * @ORM\Table(name="chambre")
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
     * @ORM\Column(name="type", type="string", length=0, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="vue", type="string", length=0, nullable=false)
     */
    private $vue;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_nuitee", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixNuitee;


}
