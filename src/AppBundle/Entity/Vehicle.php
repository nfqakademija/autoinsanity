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
     * @var string
     *
     * @ORM\Column(name="link", type="string")
     */
    private $link;

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
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set providerId
     */
    public function setProviderId(int $providerId): Vehicle
    {
        $this->providerId = $providerId;

        return $this;
    }

    /**
     * Get providerId
     */
    public function getProviderId():int
    {
        return $this->providerId;
    }

    /**
     * Set provider
     */
    public function setProvider(string $provider): Vehicle
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
    public function setPrice(int $price): Vehicle
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
    public function setYear(int $year): Vehicle
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
    public function setEngineSize(int $engineSize): Vehicle
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
    public function setPower(int $power): Vehicle
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
    public function setDoorsNumber(int $doorsNumber): Vehicle
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
    public function setSeatsNumber(int $seatsNumber): Vehicle
    {
        $this->seatsNumber = $seatsNumber;

        return $this;
    }

    /**
     * Get seatsNumber
     */
    public function getSeatsNumber(): int
    {
        return $this->seatsNumber;
    }

    /**
     * Set driveType
     */
    public function setDriveType(string $driveType): Vehicle
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
    public function setTransmission(string $transmission): Vehicle
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
    public function setClimateControl(string $climateControl): Vehicle
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
    public function setDefects(string $defects): Vehicle
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
    public function setSteeringWheel(int $steeringWheel): Vehicle
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
    public function setWheelsDiameter(int $wheelsDiameter): Vehicle
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
    public function setWeight(int $weight): Vehicle
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
    public function setMileage(int $mileage): Vehicle
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
    public function setColor(Color $color = null): Vehicle
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
    public function setLink(string $link): Vehicle
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
