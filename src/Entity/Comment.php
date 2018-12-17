<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 *
 * @ApiResource(
 *     itemOperations={
 *          "get",
 *          "delete"={"access_control"="is_granted('ROLE_USER') and object.poster == user"},
 *     },
 *     collectionOperations={
 *          "get",
 *          "post"={"access_control"="has_role('ROLE_USER')"},
 *     },
 *     attributes={
 *          "normalizationContext"={"groups"={"comment"}},
 *          "denormalizationContext"={"groups"={"comment_write"}}
 *     }
 * )
 *
 * @ApiFilter(OrderFilter::class, properties={"id", "createdAt"})
 * @ApiFilter(SearchFilter::class, properties={"resource": "exact"})
 * @ApiFilter(DateFilter::class)
 */
class Comment
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"comment"})
     */
    private $id;

    /**
     * @var string
     *
     * @ApiProperty(iri="https://schema.org/commentText")
     *
     * @ORM\Column(type="text")
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank()
     *
     * @Groups({"comment", "comment_write"})
     */
    private $message;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Gedmo\Blameable(on="create")
     *
     * @Groups({"comment", "comment_write"})
     */
    private $poster;

    /**
     * @var \DateTime
     *
     * @ApiProperty(iri="https://schema.org/dateCreated")
     *
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @Groups({"comment", "comment_write"})
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ApiProperty(iri="https://schema.org/propertyID")
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     *
     * @Groups({"comment", "comment_write"})
     */
    private $resource;

    public function getId(): int
    {
        return $this->id;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return Comment
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPoster(): User
    {
        return $this->poster;
    }

    /**
     * @return Comment
     */
    public function setPoster(User $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return Comment
     */
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getResource(): string
    {
        return $this->resource;
    }

    /**
     * @return Comment
     */
    public function setResource(string $resource): self
    {
        $this->resource = $resource;

        return $this;
    }
}