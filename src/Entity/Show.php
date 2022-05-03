<?php

namespace App\Entity;

use App\Repository\ShowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShowRepository::class)
 */
class Show
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link_video;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link_sound;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture_2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture_3;

    /**
     * @ORM\Column(type="time")
     */
    private $time;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="show")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity=category::class, inversedBy="shows")
     */
    private $category;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getLinkVideo(): ?string
    {
        return $this->link_video;
    }

    public function setLinkVideo(?string $link_video): self
    {
        $this->link_video = $link_video;

        return $this;
    }

    public function getLinkSound(): ?string
    {
        return $this->link_sound;
    }

    public function setLinkSound(?string $link_sound): self
    {
        $this->link_sound = $link_sound;

        return $this;
    }

    public function getPicture1(): ?string
    {
        return $this->picture_1;
    }

    public function setPicture1(?string $picture_1): self
    {
        $this->picture_1 = $picture_1;

        return $this;
    }

    public function getPicture2(): ?string
    {
        return $this->picture_2;
    }

    public function setPicture2(?string $picture_2): self
    {
        $this->picture_2 = $picture_2;

        return $this;
    }

    public function getPicture3(): ?string
    {
        return $this->picture_3;
    }

    public function setPicture3(?string $picture_3): self
    {
        $this->picture_3 = $picture_3;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addShow($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeShow($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }
}
