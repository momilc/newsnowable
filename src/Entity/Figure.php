<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FigureRepository")
 */
class Figure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $type_trick;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $style;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

//    /**
//     * @ORM\Column(type="integer")
//     */
//    private $category_id;

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

    /**
     * @return mixed
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @param mixed $style
     */
    public function setStyle($style): void
    {
        $this->style = $style;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getTypeTrick()
    {
        return $this->type_trick;
    }

    /**
     * @param mixed $type_trick
     */
    public function setTypeTrick($type_trick): void
    {
        $this->type_trick = $type_trick;
    }

//    /**
//     * @return mixed
//     */
//    public function getCategoryId()
//    {
//        return $this->category_id;
//    }
//
//    /**
//     * @param mixed $category_id
//     */
//    public function setCategoryId($category_id): void
//    {
//        $this->category_id = $category_id;
//    }



//**************************************************************//
//***************Check this for relations *************************************
//**************************************************************//
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="figures")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category = null): void
    {
        $this->category = $category;
    }


}
