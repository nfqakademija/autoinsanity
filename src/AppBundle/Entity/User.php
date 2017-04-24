<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Vehicle", inversedBy="")
     * @ORM\JoinTable(name="users_vehicles",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="vehicle_id", referencedColumnName="id")}
     *      )
     */
    private $pinnedVehicles;

    public function __construct()
    {
        parent::__construct();
        $this->pinnedVehicles = new ArrayCollection();
    }

    public function setEmail($email)
    {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        // we use email only login/register
        $this->setUsername($email);

        return $this;
    }

    /**
     * Add pinnedVehicle
     */
    public function addPinnedVehicle(Vehicle $pinnedVehicle): User
    {
        $this->pinnedVehicles[] = $pinnedVehicle;

        return $this;
    }

    /**
     * Remove pinnedVehicle
     */
    public function removePinnedVehicle(Vehicle $pinnedVehicle)
    {
        $this->pinnedVehicles->removeElement($pinnedVehicle);
    }

    /**
     * Get pinnedVehicles
     */
    public function getPinnedVehicles(): ArrayCollection
    {
        return $this->pinnedVehicles;
    }
}
