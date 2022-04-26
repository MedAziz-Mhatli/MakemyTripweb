<?php

namespace App\Entity;

use App\Repository\VolRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VolRepository::class)
 */
class Vol
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id_vol;

    
/**
     * @Assert\NotBlank(message="depart_vol doit etre non vide")
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "doit etre >=3 ",
     *      maxMessage = "doit etre <=100" )
     * @ORM\Column(type="string", length=1000)
     */

    private $depart_vol;

    /**
     * @Assert\NotBlank(message="destination_vol doit etre non vide")
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "doit etre >=3 ",
     *      maxMessage = "doit etre <=100" )
     * @ORM\Column(type="string", length=1000)
     */
    private $destination_vol;

    /**
     * @ORM\Column(type="date")
     */
    private $date_departVol;

    /**
     * @ORM\Column(type="date")
     */
    private $date_retourVol;

    /**
     * @Assert\NotBlank(message="nb_escalesVol doit etre non vide")
     * @Assert\Length(
     *      min = 1,
     *      max = 100,
     *      minMessage = "doit etre >=1 ",
     *      maxMessage = "doit etre <=100" )
     * @ORM\Column(type="integer", length=1000)
     */
    private $nb_escalesVol;

    private $prixVol;


    public function getIdVol(): ?int
    {
        return $this->id_vol;
    }


    public function getDepartVol(): ?string
    {
        return $this->depart_vol;
    }

    public function setDepartVol(string $depart_vol): self
    {
        $this->depart_vol = $depart_vol;

        return $this;
    }

    public function getDestinationVol(): ?string
    {
        return $this->destination_vol;
    }

    public function setDestinationVol(string $destination_vol): self
    {
        $this->destination_vol = $destination_vol;

        return $this;
    }

    public function getDateDepartVol(): ?\DateTimeInterface
    {
        return $this->date_departVol;
    }

    public function setDateDepartVol(\DateTimeInterface $date_departVol): self
    {
        $this->date_departVol = $date_departVol;

        return $this;
    }

    public function getDateRetourVol(): ?\DateTimeInterface
    {
        return $this->date_retourVol;
    }

    public function setDateRetourVol(\DateTimeInterface $date_retourVol): self
    {
        $this->date_retourVol = $date_retourVol;

        return $this;
    }

    public function getNbEscalesVol(): ?int
    {
        return $this->nb_escalesVol;
    }

    public function setNbEscalesVol(int $nb_escalesVol): self
    {
        $this->nb_escalesVol = $nb_escalesVol;

        return $this;
    }

    public function getPrixVol(): ?float
    {
        return $this->prixVol;
    }

    public function setPrixVol(float $prixVol): self
    {
        $this->prixVol = $prixVol;

        return $this;
    }
}
