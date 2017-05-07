<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vehicle
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehicleRepository")
 * @ORM\Table(name="vehicle")
 */

class Vehicle
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
     * @ORM\Column(name="provider_id", type="integer", nullable=true)
     */
    private $providerId = null;

    /**
     * @var string
     *
     * @ORM\Column(name="provider", type="string", nullable=true)
     */
    private $provider = null;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", nullable=true)
     */
    private $link = null;

    /**
     * @var Brand
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Brand")
     * @ORM\JoinColumn(name="brand", referencedColumnName="id")
     */
    private $brand;

    /**
     * @var Model
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Model")
     * @ORM\JoinColumn(name="model", referencedColumnName="id")
     */
    private $model;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private $price = null;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer", nullable=true)
     */
    private $year = null;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Country")
     * @ORM\JoinColumn(name="country", referencedColumnName="id")
     */
    private $country;

    /**
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\City")
     * @ORM\JoinColumn(name="city", referencedColumnName="id")
     */
    private $city;

    /**
     * @var float
     *
     * @ORM\Column(name="engine_size", type="float", nullable=true)
     */
    private $engineSize = null;

    /**
     * @var BodyType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BodyType")
     * @ORM\JoinColumn(name="body_type", referencedColumnName="id")
     */
    private $bodyType;

    /**
     * @var int
     *
     * @ORM\Column(name="power", type="integer", nullable=true)
     */
    private $power = null;

    /**
     * @var FuelType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FuelType")
     * @ORM\JoinColumn(name="fuel_type", referencedColumnName="id")
     */
    private $fuelType;

    /**
     * @var int
     *
     * @ORM\Column(name="doors_number", type="string", nullable=true)
     */
    private $doorsNumber = null;

    /**
     * @var float
     *
     * @ORM\Column(name="seats_number", type="float", nullable=true)
     */
    private $seatsNumber = null;

    /**
     * @var string
     *
     * @ORM\Column(name="drive_type", type="string", nullable=true)
     */
    private $driveType = null;

    /**
     * @var string
     *
     * @ORM\Column(name="transmission", type="string", nullable=true)
     */
    private $transmission = null;

    /**
     * @var string
     *
     * @ORM\Column(name="climate_control", type="string", nullable=true)
     */
    private $climateControl = null;

    /**
     * @var Color
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Color")
     * @ORM\JoinColumn(name="color", referencedColumnName="id")
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="defects", type="string", nullable=true)
     */
    private $defects = null;

    /**
     * @var int
     *
     * @ORM\Column(name="steering_wheel", type="string", nullable=true)
     */
    private $steeringWheel = null;

    /**
     * @var int
     *
     * @ORM\Column(name="wheels_diameter", type="string", nullable=true)
     */
    private $wheelsDiameter = null;

    /**
     * @var int
     *
     * @ORM\Column(name="weight", type="integer", nullable=true)
     */
    private $weight = null;

    /**
     * @var int
     *
     * @ORM\Column(name="mileage", type="string", nullable=true)
     */
    private $mileage = null;

    public function __construct()
    {
    }

    /**
     * Get id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set providerId
     */
    public function setProviderId(int $providerId = null): Vehicle
    {
        $this->providerId = $providerId;

        return $this;
    }

    /**
     * Get providerId
     */
    public function getProviderId(): int
    {
        return $this->providerId;
    }

    /**
     * Set provider
     */
    public function setProvider(string $provider = null): Vehicle
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     */
    public function getProvider(): string
    {
        return $this->provider;
    }

    /**
     * Set price
     */
    public function setPrice(int $price = null): Vehicle
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * Set year
     */
    public function setYear(int $year = null): Vehicle
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * Set engineSize
     */
    public function setEngineSize(int $engineSize = null): Vehicle
    {
        $this->engineSize = $engineSize;

        return $this;
    }

    /**
     * Get engineSize
     */
    public function getEngineSize():int
    {
        return $this->engineSize;
    }

    /**
     * Set power
     */
    public function setPower(int $power = null): Vehicle
    {
        $this->power = $power;

        return $this;
    }

    /**
     * Get power
     */
    public function getPower(): int
    {
        return $this->power;
    }

    /**
     * Set doorsNumber
     */
    public function setDoorsNumber(string $doorsNumber = null): Vehicle
    {
        $this->doorsNumber = $doorsNumber;

        return $this;
    }

    /**
     * Get doorsNumber
     */
    public function getDoorsNumber():int
    {
        return $this->doorsNumber;
    }

    /**
     * Set seatsNumber
     */
    public function setSeatsNumber(float $seatsNumber = null): Vehicle
    {
        $this->seatsNumber = $seatsNumber;

        return $this;
    }

    /**
     * Get seatsNumber
     */
    public function getSeatsNumber(): float
    {
        return $this->seatsNumber;
    }

    /**
     * Set driveType
     */
    public function setDriveType(string $driveType = null): Vehicle
    {
        $this->driveType = $driveType;

        return $this;
    }

    /**
     * Get driveType
     */
    public function getDriveType(): string
    {
        return $this->driveType;
    }

    /**
     * Set transmission
     */
    public function setTransmission(string $transmission = null): Vehicle
    {
        $this->transmission = $transmission;

        return $this;
    }

    /**
     * Get transmission
     */
    public function getTransmission(): string
    {
        return $this->transmission;
    }

    /**
     * Set climateControl
     */
    public function setClimateControl(string $climateControl = null): Vehicle
    {
        $this->climateControl = $climateControl;

        return $this;
    }

    /**
     * Get climateControl
     */
    public function getClimateControl(): string
    {
        return $this->climateControl;
    }

    /**
     * Set defects
     */
    public function setDefects(string $defects = null): Vehicle
    {
        $this->defects = $defects;

        return $this;
    }

    /**
     * Get defects
     */
    public function getDefects(): string
    {
        return $this->defects;
    }

    /**
     * Set steeringWheel
     */
    public function setSteeringWheel(string $steeringWheel = null): Vehicle
    {
        $this->steeringWheel = $steeringWheel;

        return $this;
    }

    /**
     * Get steeringWheel
     */
    public function getSteeringWheel(): int
    {
        return $this->steeringWheel;
    }

    /**
     * Set wheelsDiameter
     */
    public function setWheelsDiameter(string $wheelsDiameter = null): Vehicle
    {
        $this->wheelsDiameter = $wheelsDiameter;

        return $this;
    }

    /**
     * Get wheelsDiameter
     */
    public function getWheelsDiameter(): int
    {
        return $this->wheelsDiameter;
    }

    /**
     * Set weight
     */
    public function setWeight(int $weight = null): Vehicle
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * Set mileage
     */
    public function setMileage(string $mileage = null): Vehicle
    {
        $this->mileage = $mileage;

        return $this;
    }

    /**
     * Get mileage
     */
    public function getMileage(): int
    {
        return $this->mileage;
    }


    /**
     * Set brand
     */
    public function setBrand(Brand $brand = null): Vehicle
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * Set model
     */
    public function setModel(Model $model = null): Vehicle
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Set country
     */
    public function setCountry(Country $country = null): Vehicle
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * Set city
     */
    public function setCity(City $city = null): Vehicle
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * Set bodyType
     */
    public function setBodyType(BodyType $bodyType = null): Vehicle
    {
        $this->bodyType = $bodyType;

        return $this;
    }

    /**
     * Get bodyType
     */
    public function getBodyType(): BodyType
    {
        return $this->bodyType;
    }

    /**
     * Set fuelType
     */
    public function setFuelType(FuelType $fuelType = null): Vehicle
    {
        $this->fuelType = $fuelType;

        return $this;
    }

    /**
     * Get fuelType
     */
    public function getFuelType(): FuelType
    {
        return $this->fuelType;
    }

    /**
     * Set color
     */
    public function setColor(Color $color): Vehicle
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     */
    public function getColor(): Color
    {
        return $this->color;
    }

    /**
     * Set link
     */
    public function setLink(string $link = null): Vehicle
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     */
    public function getLink():string
    {
        return $this->link;
    }
}
