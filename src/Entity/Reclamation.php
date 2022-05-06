<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="reclamation_idclient", columns={"id_client"})})
 * @ORM\Entity(repositoryClass=App\Repository\ReclamationRepository::class)
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_reclamation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("reclamation")
     * @Groups("posts:read")
     */
    private $idReclamation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reclamation", type="date", nullable=false)
     * @Groups("reclamation")
     * @Groups("posts:read")
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
     *
     * @Groups("reclamation")
     * @Groups("posts:read")
     */


    private $emailReclamation;

    /**
     * @var string
     *
     * @ORM\Column(name="desription_reclamation", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Desription Reclamation est Vide !")
     * @Groups("reclamation")
     * @Groups("posts:read")
     */
    private $desriptionReclamation;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_reclamation", type="string", length=255, nullable=false)
     * @Groups("reclamation")
     * @Groups("posts:read")
     */
    private $etatReclamation;

    /**
     * @ORM\Column(name="NomUser",type="string", length=255)
     * @Assert\NotBlank(message="Veuillez remplir ce champ!")
     * @Assert\Length(
     *     min = 3 ,
     *     max = 50,
     *     minMessage = "Le nom est trop court",
     *     maxMessage="Le nom est trop long"
     * )
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z ]*$/",
     *     message="The fullname should only have letters"
     * )
     * @Groups("reclamation")
     * @Groups("posts:read")
     */

    private $nomuser;


    /**
     *
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id_client")
     * })
     * @Groups("reclamation")
     * @Groups("posts:read")
     */
    private $Client;







    /**
     * @return int
     */
    public function getIdReclamation(): ?int
    {
        return $this->idReclamation;
    }

    /**
     * @param int $idReclamation
     */
    public function setIdReclamation(int $idReclamation): void
    {
        $this->idReclamation = $idReclamation;
    }

    /**
     * @return \DateTime
     */
    public function getDateReclamation(): \DateTime
    {
        return $this->dateReclamation;
    }

    /**
     * @param \DateTime $dateReclamation
     */
    public function setDateReclamation(\DateTime $dateReclamation): void
    {
        $this->dateReclamation = $dateReclamation;
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

    /**
     * @return string
     */
    public function getDesriptionReclamation(): ?string
    {
        return $this->desriptionReclamation;
    }


    public function setDesriptionReclamation(string $desriptionReclamation): self
    {
        $this->desriptionReclamation = $desriptionReclamation;
        return $this;
    }

    /**
     * @return string
     */
    public function getEtatReclamation(): ?string
    {
        return $this->etatReclamation;
    }

    /**
     * @param string $etatReclamation
     */
    public function setEtatReclamation(string $etatReclamation): self
    {
        $this->etatReclamation = $etatReclamation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNomuser(): ?string
    {
        return $this->nomuser;
    }

    /**
     * @param mixed $nomuser
     */
    public function setNomuser($nomuser): void
    {
        $this->nomuser = $nomuser;
    }

    /**
     * @return mixed
     */
    public function getClient(): ?Client
    {
        return $this->Client;
    }

    /**
     * @param mixed $Client
     */
    public function setClient(?Client $Client): self
    {
        $this->Client = $Client;
        return $this;
    }
}
