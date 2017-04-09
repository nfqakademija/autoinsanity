<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BodyType
 *
 * @ORM\Table(name="body_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BodyTypeRepository")
 */
class BodyType
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

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
    public function setName(string $name): BodyType
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
}
