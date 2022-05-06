<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;


/**
 * Facture
 *
 * @ORM\Table(name="facture", indexes={@ORM\Index(name="IDX_FE86641019EB6921", columns={"client_id"})})
 * @ORM\Entity
 */
class Facture
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_facture", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("facture")
     * @Groups("posts:read")
     */
    private $idFacture;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_facture", type="datetime", nullable=false)
     *@Groups("facture")
     * @Groups("posts:read")
     */
    private $dateFacture;

    /**
     * @var float
     *
     * @ORM\Column(name="remise_facture", type="float", precision=10, scale=0, nullable=false)
     * @Assert\Range(
     *      min = 1,
     *      max = 100,
     *
     * )
     *
     *@Groups("facture")
     * @Groups("posts:read")
     */
    private $remiseFacture;

    /**
     * @var float
     *
     * @ORM\Column(name="total_facture", type="float", precision=10, scale=0, nullable=false)
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     htmlPattern = "[0-9]*",
     *     message = "Total doit contenir que des chiffres"
     * )
     * @Groups("facture")
     * @Groups("posts:read")
     */
    private $totalFacture;

    /**
     * @var string
     *
     * @ORM\Column(name="type_fature", type="string", length=255, nullable=false)
     *@Groups("facture")
     * @Groups("posts:read")
     */
    private $typeFature;

    /**
     *
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client_id", referencedColumnName="id_client")
     * })
     * @Groups("facture")
     * @Groups("posts:read")
     */
    private $Client;

    /**
     * @return int
     */
    public function getIdFacture(): ?int
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
    public function setTotalFacture1( $totalFacture): float
    {
        $res=$this->totalFacture = $totalFacture;

        return (float)$res;
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




    public function getClient(): ?Client
    {
        return $this->Client;
    }

    public function setClient(?Client $Client): self
    {
        $this->Client = $Client;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('totalFacture', new Assert\Regex([
            'pattern'=> '/^[0-9]*$/',
          'htmlPattern' => '[0-9]*' ,
        ]));


        $metadata->addPropertyConstraint('remiseFacture', new Assert\Range([
            'min' => 1,
            'max' => 100,
            'notInRangeMessage' => 'You must be between {{ min }}% and {{ max }}% ',
        ]));
    }
    }

