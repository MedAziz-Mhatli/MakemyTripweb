<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReservationGuide
 *
 * @ORM\Table(name="reservation_guide", indexes={@ORM\Index(name="id_resVol", columns={"id_resVol"}), @ORM\Index(name="id_guide", columns={"id_guide"})})
 * @ORM\Entity
 */
class ReservationGuide
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_resGuide", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idResguide;

    /**
     *
     *
     * @ORM\ManyToOne(targetEntity="GuideTouristique")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_guide", referencedColumnName="id_guide")
     * })
     */
    private $idGuide;

    /**
     *
     *
     * @ORM\ManyToOne(targetEntity="Res_Vol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_resVol", referencedColumnName="id_resVol")
     * })
     */
    private $idResvol;

    /**
     * @return int
     */
    public function getIdResguide()
    {
        return $this->idResguide;
    }

    /**
     * @param int $idResguide
     */
    public function setIdResguide(int $idResguide): void
    {
        $this->idResguide = $idResguide;
    }

    /**
     *
     */
    public function getIdGuide()
    {
        return $this->idGuide;
    }

    /**
     *
     */
    public function setIdGuide( $idGuide): void
    {
        $this->idGuide = $idGuide;
    }

    /**
     *
     */
    public function getIdResvol()
    {
        return $this->idResvol;
    }

    /**
     *
     */
    public function setIdResvol( $idResvol): void
    {
        $this->idResvol = $idResvol;
    }


}
