<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\EntityListeners({"App\Listener\HashPasswordListener"})
 * @UniqueEntity(fields={"username"}, message ="Ce cosmonaute existe déja !")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce contenu ne peut pas être vide")
     * @Assert\Length(min=3,minMessage="Minimum 3 caractères")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="user", cascade{"persist", "remove"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function addImages(Image $image)
    {
        $this->images->add($image);
    }

    public function removeImages(Image $image)
    {
        $this->images->removeElement($image);
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getSalt()
    {

    }
    public function eraseCredentials()
    {
    }


}
