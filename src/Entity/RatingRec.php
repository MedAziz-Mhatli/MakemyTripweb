<?php

namespace App\Entity;

use App\Repository\RatingRecRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RatingRecRepository::class)
 */
class RatingRec
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idRating;

    /**
     * @ORM\Column(type="float")
     */
    private $ratingrec;

    /**
     * @ORM\ManyToOne(targetEntity=Reclamation::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_reclamation", referencedColumnName="id_reclamation")
     * })
     */
    private $idrec;

    /**
     * @return mixed
     */
    public function getIdRating()
    {
        return $this->idRating;
    }

    /**
     * @param mixed $idRating
     */
    public function setIdRating($idRating): void
    {
        $this->idRating = $idRating;
    }

    /**
     * @return mixed
     */
    public function getIdrec()
    {
        return $this->idrec;
    }

    /**
     * @param mixed $idrec
     */
    public function setIdrec($idrec): void
    {
        $this->idrec = $idrec;
    }


    public function getId(): ?int
    {
        return $this->idRating;
    }

    public function getRatingrec(): ?float
    {
        return $this->ratingrec;
    }

    public function setRatingrec(float $ratingrec): self
    {
        $this->ratingrec = $ratingrec;

        return $this;
    }
}
