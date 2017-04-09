<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model
 *
 * @ORM\Table(name="model")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModelRepository")
 */
class Model
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Brand
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Brand", inversedBy="id")
     * @ORM\JoinColumn(name="brand", referencedColumnName="id")
     */
    private $brand;


    /**
     * Get id
     */
    public function getId(): integer
    {
        return $this->id;
    }

    /**
     * Set name
     */
    public function setName(string $name): Model
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set brand
     */
    public function setBrand(integer $brand): Model
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     */
    public function getBrand(): integer
    {
        return $this->brand;
    }
}

