<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\FactureRepository;
use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_facture", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *

     */
    private $idFacture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_facture", type="date", nullable=false)
     */
    private $dateFacture;

    /**
     * @var float
     *
     * @ORM\Column(name="remise_facture", type="float", precision=10, scale=0, nullable=false)
     * @Assert\NotBlank(message="Remise est Vide !")
     */
    private $remiseFacture;

    /**
     * @var float
     *
     * @ORM\Column(name="total_facture", type="float", precision=10, scale=0, nullable=false)
     */
    private $totalFacture;

    /**
     * @var string
     *
     * @ORM\Column(name="type_fature", type="string", length=255, nullable=false)
     */
    private $typeFature;

    /**
     * @var int
     *
     * @ORM\Column(name="id_client", type="integer", nullable=false)
     */
    private $idClient;

    /**
     * @return int
     */
    public function getIdFacture(): int
    {
        return $this->idFacture;
    }

    /**
     * @param int $idFacture
     */
    public function setIdFacture(int $idFacture): void
    {
        $this->idFacture = $idFacture;
    }


    public function getDateFacture(): ?\DateTimeInterface
    {
        return $this->dateFacture;
    }

    public function setDateFacture(\DateTimeInterface $dateFacture): self
    {
        $this->dateFacture = $dateFacture;

        return $this;
    }

    public function getRemiseFacture(): ?float
    {
        return $this->remiseFacture;
    }

    public function setRemiseFacture(float $remiseFacture): self
    {
        $this->remiseFacture = $remiseFacture;

        return $this;
    }
    public function getTotalFacture(): ?float
    {
        return $this->totalFacture;
    }

    public function setTotalFacture(float $totalFacture): self
    {
        $this->totalFacture = $totalFacture;

        return $this;
    }

    public function getTypeFature(): ?string
    {
        return $this->typeFature;
    }

    public function setTypeFature(string $typeFature): self
    {
        $this->typeFature = $typeFature;

        return $this;
    }

    public function getIdClient(): ?int
    {
        return $this->idClient;
    }

    public function setIdClient(int $idClient): self
    {
        $this->idClient = $idClient;

        return $this;
    }




}
