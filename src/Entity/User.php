<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}}
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Cet email est déjà utilisé."
 * )
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"client:read", "user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"client:read", "user:read", "user:write"})
     *
     * @Assert\Length(
     *      min = 3,
     *      max = 30,
     *      minMessage = "Le firstName foit faire minimum {{ limit }} caractères de long",
     *      maxMessage = "Le firstName foit faire maximum {{ limit }} caractères de long"
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"client:read", "user:read", "user:write"})
     *
     * @Assert\Length(
     *      min = 3,
     *      max = 30,
     *      minMessage = "Le lastName foit faire minimum {{ limit }} caractères de long",
     *      maxMessage = "Le lastName foit faire maximum {{ limit }} caractères de long"
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"client:read", "user:read", "user:write"})
     *
     * @Assert\NotBlank(message = "L'email doit être renseigné.")
     * @Assert\Email(message = "L'email '{{ value }}' n'est pas un email valide.")
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
