<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var Provider
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Provider")
     * @ORM\JoinColumn(name="provider", referencedColumnName="id")
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
     * @var int
     *
     * @ORM\Column(name="engine_size", type="integer", nullable=true)
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
     * @ORM\Column(name="doors_number", type="integer", nullable=true)
     */
    private $doorsNumber = null;

    /**
     * @var int
     *
     * @ORM\Column(name="seats_number", type="integer", nullable=true)
     */
    private $seatsNumber = null;

    /**
     * @var int
     *
     * @ORM\Column(name="drive_type", type="integer", nullable=true)
     */
    private $driveType = null;

    /**
     * @var Transmission
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Transmission")
     * @ORM\JoinColumn(name="transmission", referencedColumnName="id")
     */
    private $transmission = null;

    /**
     * @var ClimateControl
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ClimateControl")
     * @ORM\JoinColumn(name="climate_control", referencedColumnName="id")
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
     * @var Defects
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Defects")
     * @ORM\JoinColumn(name="defects", referencedColumnName="id")
     */
    private $defects;

    /**
     * @var int
     *
     * @ORM\Column(name="steering_wheel", type="integer", nullable=true)
     */
    private $steeringWheel = null;

    /**
     * @var int
     *
     * @ORM\Column(name="wheels_diameter", type="integer", nullable=true)
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
     * @ORM\Column(name="mileage", type="integer", nullable=true)
     */
    private $mileage = null;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", nullable=true)
     */
    private $image = null;

    /**
     * @var int
     *
     * @ORM\Column(name="next_check_year", type="integer", nullable=true)
     */
    private $nextCheckYear = null;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Country")
     * @ORM\JoinColumn(name="first_country", referencedColumnName="id")
     */
    private $firstCountry;

    /**
     * @var int
     *
     * @ORM\Column(name="gears_number", type="integer", nullable=true)
     */
    private $gearsNumber = null;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_ad_update", type="datetime", nullable=true)
     */
    private $lastAdUpdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_check", type="datetime", nullable=true)
     */
    private $lastCheck;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="User", mappedBy="pinnedVehicles")
     */
    private $users;

    /**
     * Vehicle constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
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
    public function setProvider(Provider $provider = null): Vehicle
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     */
    public function getProvider(): Provider
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
    public function getEngineSize(): int
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
    public function getPower(): ? int
    {
        return $this->power;
    }

    /**
     * Set doorsNumber
     */
    public function setDoorsNumber(int $doorsNumber = null): Vehicle
    {
        $this->doorsNumber = $doorsNumber;

        return $this;
    }

    /**
     * Get doorsNumber
     */
    public function getDoorsNumber(): ? int
    {
        return $this->doorsNumber;
    }

    /**
     * Set seatsNumber
     */
    public function setSeatsNumber(int $seatsNumber = null): Vehicle
    {
        $this->seatsNumber = $seatsNumber;

        return $this;
    }

    /**
     * Get seatsNumber
     */
    public function getSeatsNumber(): ? int
    {
        return $this->seatsNumber;
    }

    /**
     * Set driveType
     */
    public function setDriveType(int $driveType = null): Vehicle
    {
        $this->driveType = $driveType;

        return $this;
    }

    /**
     * Get driveType
     */
    public function getDriveType(): ? int
    {
        return $this->driveType;
    }

    /**
     * Set steeringWheel
     */
    public function setSteeringWheel(int $steeringWheel = null): Vehicle
    {
        $this->steeringWheel = $steeringWheel;

        return $this;
    }

    /**
     * Get steeringWheel
     */
    public function getSteeringWheel(): ? int
    {
        return $this->steeringWheel;
    }

    /**
     * Set wheelsDiameter
     */
    public function setWheelsDiameter(int $wheelsDiameter = null): Vehicle
    {
        $this->wheelsDiameter = $wheelsDiameter;

        return $this;
    }

    /**
     * Get wheelsDiameter
     */
    public function getWheelsDiameter(): ? int
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
    public function getWeight(): ? int
    {
        return $this->weight;
    }

    /**
     * Set mileage
     */
    public function setMileage(int $mileage = null): Vehicle
    {
        $this->mileage = $mileage;

        return $this;
    }

    /**
     * Get mileage
     */
    public function getMileage(): ? int
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
    public function getBodyType(): ? BodyType
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
    public function getFuelType(): ? FuelType
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
    public function getColor(): ? Color
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
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * Set image
     */
    public function setImage(string $image): Vehicle
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     */
    public function getImage(): ? string
    {
        return $this->image;
    }


    /**
     * Set transmission
     */
    public function setTransmission(Transmission $transmission = null): Vehicle
    {
        $this->transmission = $transmission;

        return $this;
    }

    /**
     * Get transmission
     */
    public function getTransmission(): ? Transmission
    {
        return $this->transmission;
    }

    /**
     * Set climateControl
     *
     * @return Vehicle
     */
    public function setClimateControl(ClimateControl $climateControl = null): Vehicle
    {
        $this->climateControl = $climateControl;

        return $this;
    }

    /**
     * Get climateControl
     */
    public function getClimateControl(): ? ClimateControl
    {
        return $this->climateControl;
    }

    /**
     * Set defects
     */
    public function setDefects(Defects $defects = null): Vehicle
    {
        $this->defects = $defects;

        return $this;
    }

    /**
     * Get defects
     */
    public function getDefects(): ? Defects
    {
        return $this->defects;
    }

    /**
     * Set nextCheckYear
     */
    public function setNextCheckYear(int $nextCheckYear = null): Vehicle
    {
        $this->nextCheckYear = $nextCheckYear;

        return $this;
    }

    /**
     * Get nextCheckYear
     */
    public function getNextCheckYear(): ? int
    {
        return $this->nextCheckYear;
    }

    /**
     * Set gearsNumber
     */
    public function setGearsNumber(int $gearsNumber = null): Vehicle
    {
        $this->gearsNumber = $gearsNumber;

        return $this;
    }

    /**
     * Get gearsNumber
     */
    public function getGearsNumber(): ? int
    {
        return $this->gearsNumber;
    }

    /**
     * Set lastAdUpdate
     */
    public function setLastAdUpdate(\DateTime $lastAdUpdate): Vehicle
    {
        $this->lastAdUpdate = $lastAdUpdate;

        return $this;
    }

    /**
     * Get lastAdUpdate
     */
    public function getLastAdUpdate(): ? \DateTime
    {
        return $this->lastAdUpdate;
    }

    /**
     * Set lastCheck
     */
    public function setLastCheck(\DateTime $lastCheck): Vehicle
    {
        $this->lastCheck = $lastCheck;

        return $this;
    }

    /**
     * Get lastCheck
     */
    public function getLastCheck(): \DateTime
    {
        return $this->lastCheck;
    }

    /**
     * Set firstCountry
     */
    public function setFirstCountry(Country $firstCountry = null): Vehicle
    {
        $this->firstCountry = $firstCountry;

        return $this;
    }

    /**
     * Get firstCountry
     */
    public function getFirstCountry(): ? Country
    {
        return $this->firstCountry;
    }

    /**
     * Add user
     */
    public function addUser(User $user): Vehicle
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     */
    public function getUsers(): ArrayCollection
    {
        return $this->users;
    }
}
