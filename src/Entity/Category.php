<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }
//**************************************************************//
//***************Check this for relations *************************************
//**************************************************************//
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Figure", mappedBy="category", orphanRemoval=true)
     */
    private $figures;

    public function __construct()
    {
        $this->figures = new ArrayCollection();
    }

    /**
     * @return Collection|Figure[]
     */
    public function getFigures()
    {
        return $this->figures;
    }

    /**
     * @param Figure $figure
     */
    public function addFigure(Figure $figure): void
    {
        if ($this->figures->contains($figure)) {
            return;
        }

        $this->figures[] = $figure;
        // set the *owning* side!
        $figure->setCategory($this);
    }

    /**
     * @param Figure $figure
     */
    public function removeFigure(Figure $figure): void
    {
        $this->figures->removeElement($figure);
        // set the owning side to null
        $figure->setCategory();
    }


}
