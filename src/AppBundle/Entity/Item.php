<?php

namespace AppBundle\Entity;

use AppBundle\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Item
 *
 * @ORM\Entity(repositoryClass="ItemRepository")
 * @ORM\Table(name="item")
 */

class Item
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="provider_id", type="integer")
     */
    private $providerId;

    /**
     * @var string
     *
     * @ORM\Column(name="provider", type="string")
     */
    private $provider;

    /**
     * @var Brand
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Brand", inversedBy="id")
     * @ORM\JoinColumn(name="brand", referencedColumnName="id")
     */
    private $brand;

    /**
     * @var Model
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Model", inversedBy="id")
     * @ORM\JoinColumn(name="model", referencedColumnName="id")
     */
    private $model;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Country", inversedBy="id")
     * @ORM\JoinColumn(name="country", referencedColumnName="id")
     */
    private $country;

    /**
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\City", inversedBy="id")
     * @ORM\JoinColumn(name="city", referencedColumnName="id")
     */
    private $city;

    /**
     * @var int
     *
     * @ORM\Column(name="engine_size", type="integer")
     */
    private $engineSize;

    /**
     * @var BodyType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BodyType", inversedBy="id")
     * @ORM\JoinColumn(name="body_type", referencedColumnName="id")
     */
    private $bodyType;

    /**
     * @var int
     *
     * @ORM\Column(name="power", type="integer")
     */
    private $power;

    /**
     * @var FuelType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FuelType", inversedBy="id")
     * @ORM\JoinColumn(name="fuel_type", referencedColumnName="id")
     */
    private $fuelType;

    /**
     * @var int
     *
     * @ORM\Column(name="doors_number", type="integer")
     */
    private $doorsNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="seats_number", type="integer")
     */
    private $seatsNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="drive_type", type="string")
     */
    private $driveType;

    /**
     * @var string
     *
     * @ORM\Column(name="transmission", type="string")
     */
    private $transmission;

    /**
     * @var string
     *
     * @ORM\Column(name="climate_control", type="string")
     */
    private $climateControl;

    /**
     * @var Color
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Color", inversedBy="id")
     * @ORM\JoinColumn(name="color", referencedColumnName="id")
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="defects", type="string")
     */
    private $defects;

    /**
     * @var int
     *
     * @ORM\Column(name="steering_wheel", type="integer")
     */
    private $steeringWheel;

    /**
     * @var int
     *
     * @ORM\Column(name="wheels_diameter", type="integer")
     */
    private $wheelsDiameter;

    /**
     * @var int
     *
     * @ORM\Column(name="weight", type="integer")
     */
    private $weight;

    /**
     * @var int
     *
     * @ORM\Column(name="mileage", type="integer")
     */
    private $mileage;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set providerId
     *
     * @param integer $providerId
     *
     * @return Item
     */
    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;

        return $this;
    }

    /**
     * Get providerId
     *
     * @return integer
     */
    public function getProviderId()
    {
        return $this->providerId;
    }

    /**
     * Set provider
     *
     * @param string $provider
     *
     * @return Item
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Item
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Item
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set engineSize
     *
     * @param integer $engineSize
     *
     * @return Item
     */
    public function setEngineSize($engineSize)
    {
        $this->engineSize = $engineSize;

        return $this;
    }

    /**
     * Get engineSize
     *
     * @return integer
     */
    public function getEngineSize()
    {
        return $this->engineSize;
    }

    /**
     * Set power
     *
     * @param integer $power
     *
     * @return Item
     */
    public function setPower($power)
    {
        $this->power = $power;

        return $this;
    }

    /**
     * Get power
     *
     * @return integer
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * Set doorsNumber
     *
     * @param integer $doorsNumber
     *
     * @return Item
     */
    public function setDoorsNumber($doorsNumber)
    {
        $this->doorsNumber = $doorsNumber;

        return $this;
    }

    /**
     * Get doorsNumber
     *
     * @return integer
     */
    public function getDoorsNumber()
    {
        return $this->doorsNumber;
    }

    /**
     * Set seatsNumber
     *
     * @param integer $seatsNumber
     *
     * @return Item
     */
    public function setSeatsNumber($seatsNumber)
    {
        $this->seatsNumber = $seatsNumber;

        return $this;
    }

    /**
     * Get seatsNumber
     *
     * @return integer
     */
    public function getSeatsNumber()
    {
        return $this->seatsNumber;
    }

    /**
     * Set driveType
     *
     * @param string $driveType
     *
     * @return Item
     */
    public function setDriveType($driveType)
    {
        $this->driveType = $driveType;

        return $this;
    }

    /**
     * Get driveType
     *
     * @return string
     */
    public function getDriveType()
    {
        return $this->driveType;
    }

    /**
     * Set transmission
     *
     * @param string $transmission
     *
     * @return Item
     */
    public function setTransmission($transmission)
    {
        $this->transmission = $transmission;

        return $this;
    }

    /**
     * Get transmission
     *
     * @return string
     */
    public function getTransmission()
    {
        return $this->transmission;
    }

    /**
     * Set climateControl
     *
     * @param string $climateControl
     *
     * @return Item
     */
    public function setClimateControl($climateControl)
    {
        $this->climateControl = $climateControl;

        return $this;
    }

    /**
     * Get climateControl
     *
     * @return string
     */
    public function getClimateControl()
    {
        return $this->climateControl;
    }

    /**
     * Set defects
     *
     * @param string $defects
     *
     * @return Item
     */
    public function setDefects($defects)
    {
        $this->defects = $defects;

        return $this;
    }

    /**
     * Get defects
     *
     * @return string
     */
    public function getDefects()
    {
        return $this->defects;
    }

    /**
     * Set steeringWheel
     *
     * @param integer $steeringWheel
     *
     * @return Item
     */
    public function setSteeringWheel($steeringWheel)
    {
        $this->steeringWheel = $steeringWheel;

        return $this;
    }

    /**
     * Get steeringWheel
     *
     * @return integer
     */
    public function getSteeringWheel()
    {
        return $this->steeringWheel;
    }

    /**
     * Set wheelsDiameter
     *
     * @param integer $wheelsDiameter
     *
     * @return Item
     */
    public function setWheelsDiameter($wheelsDiameter)
    {
        $this->wheelsDiameter = $wheelsDiameter;

        return $this;
    }

    /**
     * Get wheelsDiameter
     *
     * @return integer
     */
    public function getWheelsDiameter()
    {
        return $this->wheelsDiameter;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     *
     * @return Item
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set mileage
     *
     * @param integer $mileage
     *
     * @return Item
     */
    public function setMileage($mileage)
    {
        $this->mileage = $mileage;

        return $this;
    }

    /**
     * Get mileage
     *
     * @return integer
     */
    public function getMileage()
    {
        return $this->mileage;
    }

    /**
     * Set brand
     *
     * @param \AppBundle\Entity\Brand $brand
     *
     * @return Item
     */
    public function setBrand(\AppBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \AppBundle\Entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set model
     *
     * @param \AppBundle\Entity\Model $model
     *
     * @return Item
     */
    public function setModel(\AppBundle\Entity\Model $model = null)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return \AppBundle\Entity\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set country
     *
     * @param \AppBundle\Entity\Country $country
     *
     * @return Item
     */
    public function setCountry(\AppBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \AppBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set city
     *
     * @param \AppBundle\Entity\City $city
     *
     * @return Item
     */
    public function setCity(\AppBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \AppBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set bodyType
     *
     * @param \AppBundle\Entity\BodyType $bodyType
     *
     * @return Item
     */
    public function setBodyType(\AppBundle\Entity\BodyType $bodyType = null)
    {
        $this->bodyType = $bodyType;

        return $this;
    }

    /**
     * Get bodyType
     *
     * @return \AppBundle\Entity\BodyType
     */
    public function getBodyType()
    {
        return $this->bodyType;
    }

    /**
     * Set fuelType
     *
     * @param \AppBundle\Entity\FuelType $fuelType
     *
     * @return Item
     */
    public function setFuelType(\AppBundle\Entity\FuelType $fuelType = null)
    {
        $this->fuelType = $fuelType;

        return $this;
    }

    /**
     * Get fuelType
     *
     * @return \AppBundle\Entity\FuelType
     */
    public function getFuelType()
    {
        return $this->fuelType;
    }

    /**
     * Set color
     *
     * @param \AppBundle\Entity\Color $color
     *
     * @return Item
     */
    public function setColor(\AppBundle\Entity\Color $color = null)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \AppBundle\Entity\Color
     */
    public function getColor()
    {
        return $this->color;
    }
}
