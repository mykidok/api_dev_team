<?php

namespace App\Entity;

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
 *          "validate_article",
 *          "put"={"access_control"="has_role('ROLE_ADMIN')"},
 *          "delete"={"access_control"="has_role('ROLE_ADMIN')"},
 *     },
 *     collectionOperations={
 *          "get",
 *          "post"={"access_control"="has_role('ROLE_ADMIN')"},
 *     },
 *     attributes={
 *          "normalizationContext"={"groups"={"article"}},
 *          "denormalizationContext"={"groups"={"article_write"}}
 *     }
 * )
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"article"})
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Gedmo\Blameable(on="create")
     *
     * @Groups({"article", "article_write"})
     */
    private $poster;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @Groups({"article", "article_write"})
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Assert\NotNull()
     * @Groups({"article", "article_write"})
     */
    private $title;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @Groups({"article", "article_write"})
     */
    private $isValid = false;

    /**
     * @var Chronicle
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Chronicle", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotNull()
     * @Groups({"article", "article_write"})
     */
    private $chronicle;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPoster(): User
    {
        return $this->poster;
    }

    /**
     * @return Article
     */
    public function setPoster(User $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @return Article
     */
    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return Article
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return$this;
    }

    public function getChronicle(): Chronicle
    {
        return $this->chronicle;
    }

    /**
     * @return Article
     */
    public function setChronicle(Chronicle $chronicle): self
    {
        $this->chronicle = $chronicle;

        return $this;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @return Article
     */
    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }


}