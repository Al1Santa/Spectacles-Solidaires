<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
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
     * @ORM\Column(type="text")
     */
    private $content_2;

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
     * @ORM\Column(type="text", nullable=true)
     */
    private $age;

     /**
     * @ORM\Column(type="text")
     */
    private $technique_1;

    /**
     * @ORM\Column(type="text")
     */
    private $technique_2;

    /**
     * @ORM\Column(type="text")
     */
    private $technique_3;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="events")
     */
    private $category;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bonus_1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bonus_2;

   
    public function __construct()
    {
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

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(?string $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    public function getContent2(): ?string
    {
        return $this->content_2;
    }

    public function setContent2(string $content_2): self
    {
        $this->content_2 = $content_2;

        return $this;
    }

    public function getTechnique1(): ?string
    {
        return $this->technique_1;
    }

    public function setTechnique1(string $technique_1): self
    {
        $this->technique_1 = $technique_1;

        return $this;
    }

    public function getTechnique2(): ?string
    {
        return $this->technique_2;
    }

    public function setTechnique2(string $technique_2): self
    {
        $this->technique_2 = $technique_2;

        return $this;
    }

    public function getTechnique3(): ?string
    {
        return $this->technique_3;
    }

    public function setTechnique3(string $technique_3): self
    {
        $this->technique_3 = $technique_3;

        return $this;
    }

    public function getBonus1(): ?string
    {
        return $this->bonus_1;
    }

    public function setBonus1(?string $bonus_1): self
    {
        $this->bonus_1 = $bonus_1;

        return $this;
    }

    public function getBonus2(): ?string
    {
        return $this->bonus_2;
    }

    public function setBonus2(?string $bonus_2): self
    {
        $this->bonus_2 = $bonus_2;

        return $this;
    }
}
