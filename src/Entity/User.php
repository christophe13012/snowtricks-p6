<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    public function __construct()
    {
        $this->is_admin = 0;
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /** @ORM\Column(type="integer") **/
    private $is_admin;

    /** @ORM\Column(type="string", nullable = true) **/
    private $reset_link_token;

    /** @ORM\Column(type="datetime", nullable = true) **/
    private $exp_date;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIsAdmin()
    {
        return $this->is_admin;
    }

    public function setIsAdmin($is_admin)
    {
        $this->is_admin = $is_admin;
    }


    public function getResetLinkToken()
    {
        return $this->reset_link_token;
    }

    public function setResetLinkToken($reset_link_token)
    {
        $this->reset_link_token = $reset_link_token;
    }

    public function getExpDate()
    {
        return $this->exp_date;
    }

    public function setExpDate($exp_date)
    {
        $this->exp_date = $exp_date;
    }
}
