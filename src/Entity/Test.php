<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TestRepository::class)
 */
class Test
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $testarray = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTestarray(): ?array
    {
        return $this->testarray;
    }

    public function setTestarray(array $testarray): self
    {
        $this->testarray = $testarray;

        return $this;
    }
}
