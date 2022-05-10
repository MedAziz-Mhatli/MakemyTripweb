<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("posts:read")
     */
    private $id_client;


    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("posts:read")
     */
    private $nom_client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse_client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone_client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email_client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mdp_client;

    /**
     * @ORM\OneToMany(targetEntity=Facture::class, mappedBy="Client")
     */
    private $facture;

    /**
     * @ORM\OneToMany(targetEntity=Reclamation::class, mappedBy="Client")
     */
    private $reclamations;

    /**
     * @param $facture
     */
    public function __construct($facture)
    {
        $this->facture = $facture;
        $this->reclamations = new ArrayCollection();
    }
    public function __toString()
    {
        return (string) $this->getId();
    }

    public function getId(): ?int
    {
        return $this->id_client;
    }

    public function getIdClient(): ?int
    {
        return $this->id_client;
    }

    public function setIdClient(int $id_client): self
    {
        $this->id_client = $id_client;

        return $this;
    }

    public function getNomClient(): ?string
    {
        return $this->nom_client;
    }

    public function setNomClient(string $nom_client): self
    {
        $this->nom_client = $nom_client;

        return $this;
    }

    public function getPrenomClient(): ?string
    {
        return $this->prenom_client;
    }

    public function setPrenomClient(string $prenom_client): self
    {
        $this->prenom_client = $prenom_client;

        return $this;
    }

    public function getAdresseClient(): ?string
    {
        return $this->adresse_client;
    }

    public function setAdresseClient(string $adresse_client): self
    {
        $this->adresse_client = $adresse_client;

        return $this;
    }

    public function getTelephoneClient(): ?string
    {
        return $this->telephone_client;
    }

    public function setTelephoneClient(string $telephone_client): self
    {
        $this->telephone_client = $telephone_client;

        return $this;
    }

    public function getEmailClient(): ?string
    {
        return $this->email_client;
    }

    public function setEmailClient(string $email_client): self
    {
        $this->email_client = $email_client;

        return $this;
    }

    public function getMdpClient(): ?string
    {
        return $this->mdp_client;
    }

    public function setMdpClient(string $mdp_client): self
    {
        $this->mdp_client = $mdp_client;

        return $this;
    }

    /**
     * @return Collection<int, Facture>
     */
    public function getFacture(): Collection
    {
        return $this->facture;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->facture->contains($facture)) {
            $this->facture[] = $facture;
            $facture->setClients($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->facture->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getClient() === $this) {
                $facture->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reclamation>
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations[] = $reclamation;
            $reclamation->setClient($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getClient() === $this) {
                $reclamation->setClient(null);
            }
        }

        return $this;
    }
}

