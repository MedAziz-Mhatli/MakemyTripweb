<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation")
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_reclamation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReclamation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reclamation", type="date", nullable=false)
     */
    private $dateReclamation;

    /**
     * @var string
     *
     * @ORM\Column(name="email_reclamation", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Email User est Vide !")
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $emailReclamation;

    /**
     * @var string
     *
     * @ORM\Column(name="desription_reclamation", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Desription Reclamation est Vide !")
     */
    private $desriptionReclamation;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_reclamation", type="string", length=255, nullable=false)
     */
    private $etatReclamation;

    /**
     * @var int
     *
     * @ORM\Column(name="id_client", type="integer", nullable=false)
     */
    private $idClient;

    /**
     * @var string
     *
     * @ORM\Column(name="NomUser", type="string", length=255, nullable=false)
     */
    private $nomuser;

    public function getIdReclamation(): ?int
    {
        return $this->idReclamation;
    }

    public function getDateReclamation(): ?\DateTimeInterface
    {
        return $this->dateReclamation;
    }

    public function setDateReclamation(\DateTimeInterface $dateReclamation): self
    {
        $this->dateReclamation = $dateReclamation;

        return $this;
    }

    public function getEmailReclamation(): ?string
    {
        return $this->emailReclamation;
    }

    public function setEmailReclamation(string $emailReclamation): self
    {
        $this->emailReclamation = $emailReclamation;

        return $this;
    }

    public function getDesriptionReclamation(): ?string
    {
        return $this->desriptionReclamation;
    }

    public function setDesriptionReclamation(string $desriptionReclamation): self
    {
        $this->desriptionReclamation = $desriptionReclamation;

        return $this;
    }

    public function getEtatReclamation(): ?string
    {
        return $this->etatReclamation;
    }

    public function setEtatReclamation(string $etatReclamation): self
    {
        $this->etatReclamation = $etatReclamation;

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

    public function getNomUser(): ?string
    {
        return $this->nomuser;
    }

    public function setNomUser(string $nomuser): self
    {
        $this->nomuser = $nomuser;

        return $this;
    }

}
