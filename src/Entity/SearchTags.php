<?php

namespace App\Entity;

class SearchTags
{

    private $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName($name): ?self
    {
        $this->name = $name;

        return $this;
    }

}