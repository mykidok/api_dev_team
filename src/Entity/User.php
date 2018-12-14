<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 *
 * @ApiResource(
 *     itemOperations={
 *          "get",
 *          "put"={"access_control"="is_granted('ROLE_USER') and object == user"},
 *          "update_password",
 *     },
 *     collectionOperations={
 *          "get",
 *          "create_user",
 *     },
 *     attributes={
 *          "normalizationContext"={"groups"={"user"}},
 *          "denormalizationContext"={"groups"={"user_write"}}
 *     }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"user"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *
     * @Groups({"user", "user_write"})
     */
    private $username;

    /**
     * @var string
     *
     * @ApiProperty(iri="https://schema.org/givenName")
     *
     * @ORM\Column(length=50)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(min=1, max=50)
     * @Assert\NotNull()
     * @Assert\NotBlank()
     *
     * @Groups({"user", "user_write"})
     */
    private $firstname;

    /**
     * @var string
     *
     * @ApiProperty(iri="https://schema.org/familyName")
     *
     * @ORM\Column(nullable=false, length=50)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(min=1, max=50)
     * @Assert\NotNull()
     * @Assert\NotBlank()
     *
     * @Groups({"user", "user_write"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="json")
     *
     * @Groups({"user", "user_write"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     *
     * @Groups({"user", "user_write"})
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return User
     */
    public function setFirstname(string $firstname): User
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @return User
     */
    public function setLastname(string $lastname): User
    {
        $this->lastname = $lastname;

        return $this;
    }
}
