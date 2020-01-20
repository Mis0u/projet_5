<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class Contact
{
    /**
     * @Assert\NotBlank(message="Si je n'ai pas votre nom, comment savoir à qui je m'adresse !!!")
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Une seule lettre voyons! Donnez moi au moins un surnom...",
     *      maxMessage = "Un prénom qui a plus de 19 lettres, mais bien sûr !"
     * )
     */
    private $name;
    
    /**
     * @Assert\NotBlank(message="Si je n'ai pas votre email, comment vous répondre !!!")
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas au bon format"
     * )
     */
    private $email;

    /**
     *@Assert\NotBlank(message="Allo Houston, vous avez oublié de renseigner votre message")
     */
    private $message;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName (string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail (string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage (string $message): self
    {
        $this->message = $message;

        return $this;
    }
}