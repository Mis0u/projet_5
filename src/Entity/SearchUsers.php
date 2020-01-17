<?php

namespace App\Entity;

class SearchUsers
{
    private $username;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): ?self
    {
        $this->username = $username;

        return $this;
    }
}