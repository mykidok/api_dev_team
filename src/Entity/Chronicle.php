<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 *
 * @ApiResource(
 *     itemOperations={
 *          "get",
 *          "put"={"access_control"="has_role('ROLE_ADMIN')"},
 *          "delete"={"access_control"="has_role('ROLE_ADMIN')"},
 *     },
 *     collectionOperations={
 *          "get",
 *          "post"={"access_control"="has_role('ROLE_ADMIN')"},
 *     },
 *     attributes={
 *          "normalizationContext"={"groups"={"chronicle"}},
 *          "denormalizationContext"={"groups"={"chronicle_write"}}
 *     }
 * )
 */
class Chronicle
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"chronicle"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotNull()
     * @Groups({"chronicle", "chronicle_write"})
     */
    private $name;

    /**
     * @var Article[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="chronicle")
     *
     * @Groups({"chronicle", "chronicle_write"})
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Chronicle
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getArticles(): Collection
    {
        return $this->articles;
    }

    /**
     * @return Chronicle
     */
    public function addArticle($article): self
    {
        $this->articles->add($article);

        return $this;
    }

    /**
     * @return Chronicle
     */
    public function removeArticle($article): self
    {
        $this->articles->remove($article);

        return $this;
    }
}