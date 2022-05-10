<?php

namespace App\Entity;

use App\Repository\ResVolRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ResVolRepository::class)
 */
class Res_Vol
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id_resVol;



    /**
     * @ORM\Column(type="date")
     */
    private $date_resVol;
/**
     * @Assert\NotBlank(message="companie aerienne doit etre non vide")
     * @Assert\Length(
     *      min = 4,
     *      max = 100,
     *      minMessage = "doit etre >=4 ",
     *      maxMessage = "doit etre <=100" )
     * @ORM\Column(type="string", length=1000)
     */
    private $compagnie_aerienne;
/**
     * @Assert\NotBlank(message="classe doit etre non vide")
     * @Assert\Length(
     *      min = 1,
     *      max = 100,
     *      minMessage = "doit etre >=1 ",
     *      maxMessage = "doit etre <=100" )
     * @ORM\Column(type="string", length=100)
     */
   
    private $classe;
/**
     * @Assert\NotBlank(message="nb_personnes doit etre non vide")
     * @Assert\Length(
     *      min = 1,
     *      max = 100,
     *      minMessage = "doit etre >=1 ",
     *      maxMessage = "doit etre <=100" )
     * @ORM\Column(type="integer", length=1000)
     */

    private $nb_personnes;

  

    public function getIdResVol(): ?int
    {
        return $this->id_res_vol;
    }


    public function getDateResVol(): ?\DateTimeInterface
    {
        return $this->date_resVol;
    }

    public function setDateResVol(\DateTimeInterface $date_resVol): self
    {
        $this->date_resVol = $date_resVol;

        return $this;
    }

    public function getCompagnieAerienne(): ?string
    {
        return $this->compagnie_aerienne;
    }

    public function setCompagnieAerienne(string $compagnie_aerienne): self
    {
        $this->compagnie_aerienne = $compagnie_aerienne;

        return $this;
    }

    public function getClasse(): ?string
    {
        return $this->classe;
    }

    public function setClasse(string $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getNbPersonnes(): ?int
    {
        return $this->nb_personnes;
    }

    public function setNbPersonnes(int $nb_personnes): self
    {
        $this->nb_personnes = $nb_personnes;

        return $this;
    }

}
