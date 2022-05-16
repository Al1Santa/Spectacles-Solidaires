<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("show_category_event")
     * @Groups("show_category")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     * @Groups("show_category")
     * @Groups("show_category_event")
     * @Groups("show_event")
     * 
     * @Assert\NotBlank
     * @Assert\Length(
     *      min=3,
     *      max=32, 
     *      minMessage="Le nom de la catégorie doit contenir au moins {{ limit }} caractères",
     *      maxMessage="Le nom de la catégorie ne doit pas contenir plus de {{ limit }} caractères")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="category")
     * @Groups("show_category_event")
     */
    private $events;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addCategory($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeCategory($this);
        }

        return $this;
    }
}
