<?php
/**

 */

namespace App\Entity;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

use App\Validator\Constraints\ComplexPassword;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 * @UniqueEntity(fields={"email"}, message="user.exists")
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *  @Groups("post:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank(groups={"Registration"})
     * @Assert\Email()
     *  @Groups("post:read")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(groups={"Registration", "PasswordReset"})
     * @ComplexPassword()
     *  @Groups("post:read")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     *  @Groups("post:read")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(message="Ce Champ est obligatoire")
     *  @Groups("post:read")
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     *  @Groups("post:read")
     */
    private $token;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     *  @Groups("post:read")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     *  @Groups("post:read")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *  @Groups("post:read")
     */
    private $activatedAt;


    /**
     * @var int
     *
     * @ORM\Column(name="phone", type="integer", nullable=false)
     * @Assert\NotBlank(message="Le Champ Téléphone est obligatoire")
     * @Assert\Length(
     *     min=8,
     *     minMessage="Le numéro de téléphone doit contenir au moins 8 cacartères !")
     */
    private $phone;


    /**
     * @return integer
     *  @Groups("post:read")
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getphone(): ?int
    {
        return $this->phone;
    }

    public function setphone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $nome
     */
    public function setName($nome): void
    {
        $this->name = $nome;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * @param mixed $activatedAt
     */
    public function setActivatedAt($activatedAt): void
    {
        $this->activatedAt = $activatedAt;
    }

    // not used

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->getEmail();
    }


    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->isActive;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->name,
            $this->isActive,
            $this->password,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->name,
            $this->isActive,
            $this->password,
            ) = unserialize($serialized);
    }





}