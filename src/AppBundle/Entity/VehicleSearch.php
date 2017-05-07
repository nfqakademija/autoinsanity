<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VehicleSearch
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehicleSearchRepository")
 * @ORM\Table(name="vehicle_search")
 */

class VehicleSearch
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
     * @var Provider
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Provider")
     * @ORM\JoinColumn(name="provider", referencedColumnName="id")
     */
    private $provider;

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
     * @ORM\Column(name="price_from", type="integer")
     */
    private $priceFrom;

    /**
     * @var int
     *
     * @ORM\Column(name="price_to", type="integer")
     */
    private $priceTo;

    /**
     * @var int
     *
     * @ORM\Column(name="year_from", type="integer")
     */
    private $yearFrom;

    /**
     * @var int
     *
     * @ORM\Column(name="year_to", type="integer")
     */
    private $yearTo;

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
     * @ORM\Column(name="engine_size_to", type="integer", nullable=true)
     */
    private $engineSizeTo = null;

    /**
     * @var int
     *
     * @ORM\Column(name="engine_size_from", type="integer", nullable=true)
     */
    private $engineSizeFrom = null;

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
     * @ORM\Column(name="power_from", type="integer", nullable=true)
     */
    private $powerFrom = null;

    /**
     * @var int
     *
     * @ORM\Column(name="power_to", type="integer", nullable=true)
     */
    private $powerTo = null;

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
     * @ORM\Column(name="mileage_from", type="integer", nullable=true)
     */
    private $mileageFrom = null;

    /**
     * @var int
     *
     * @ORM\Column(name="mileage_to", type="integer", nullable=true)
     */
    private $mileageTo = null;

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
     * @var int
     *
     * @ORM\Column(name="sort_type", type="integer", nullable=true)
     */
    private $sortType;

    /**
     * Vehicle constructor.
     */
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
     * Set provider
     */
    public function setProvider(Provider $provider = null): ? VehicleSearch
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * Get provider
     */
    public function getProvider(): ? Provider
    {
        return $this->provider;
    }

    /**
     * Set price from
     */
    public function setPriceFrom(int $price = null): VehicleSearch
    {
        $this->priceFrom = $price;

        return $this;
    }

    /**
     * Get price from
     */
    public function getPriceFrom(): ? int
    {
        return $this->priceFrom;
    }

    /**
     * Set price to
     */
    public function setPriceTo(int $price = null): VehicleSearch
    {
        $this->priceTo = $price;

        return $this;
    }

    /**
     * Get price to
     */
    public function getPriceTo(): ? int
    {
        return $this->priceTo;
    }

    /**
     * Set year from
     */
    public function setYearFrom(int $year = null): VehicleSearch
    {
        $this->yearFrom = $year;

        return $this;
    }

    /**
     * Get year from
     */
    public function getYearFrom(): ? int
    {
        return $this->yearFrom;
    }

    /**
     * Set year to
     */
    public function setYearTo(int $year = null): VehicleSearch
    {
        $this->yearTo = $year;

        return $this;
    }

    /**
     * Get year to
     */
    public function getYearTo(): ? int
    {
        return $this->yearTo;
    }

    /**
     * Set engineSize from
     */
    public function setEngineSizeFrom(int $engineSize = null): VehicleSearch
    {
        $this->engineSizeFrom = $engineSize;

        return $this;
    }

    /**
     * Get engineSize from
     */
    public function getEngineSizeFrom(): ? int
    {
        return $this->engineSizeFrom;
    }

    /**
     * Set engineSize to
     */
    public function setEngineSizeTo(int $engineSize = null): VehicleSearch
    {
        $this->engineSizeTo = $engineSize;

        return $this;
    }

    /**
     * Get engineSize to
     */
    public function getEngineSizeTo(): ? int
    {
        return $this->engineSizeTo;
    }

    /**
     * Set power from
     */
    public function setPowerFrom(int $power = null): VehicleSearch
    {
        $this->powerFrom = $power;

        return $this;
    }

    /**
     * Get power from
     */
    public function getPowerFrom(): ? int
    {
        return $this->powerFrom;
    }

    /**
     * Set power to
     */
    public function setPowerTo(int $power = null): VehicleSearch
    {
        $this->powerTo = $power;

        return $this;
    }

    /**
     * Get power to
     */
    public function getPowerTo(): ? int
    {
        return $this->powerTo;
    }


    /**
     * Set doorsNumber
     */
    public function setDoorsNumber(int $doorsNumber = null): VehicleSearch
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
    public function setSeatsNumber(int $seatsNumber = null): VehicleSearch
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
    public function setDriveType(int $driveType = null): VehicleSearch
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
    public function setSteeringWheel(int $steeringWheel = null): VehicleSearch
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
    public function setWheelsDiameter(int $wheelsDiameter = null): VehicleSearch
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
     * Set mileage from
     */
    public function setMileageFrom(int $mileage = null): VehicleSearch
    {
        $this->mileageFrom = $mileage;

        return $this;
    }

    /**
     * Get mileage from
     */
    public function getMileageFrom(): ? int
    {
        return $this->mileageFrom;
    }

    /**
     * Set mileage to
     */
    public function setMileageTo(int $mileage = null): VehicleSearch
    {
        $this->mileageTo = $mileage;

        return $this;
    }

    /**
     * Get mileage to
     */
    public function getMileageTo(): ? int
    {
        return $this->mileageTo;
    }


    /**
     * Set brand
     */
    public function setBrand(Brand $brand = null): VehicleSearch
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     */
    public function getBrand(): ? Brand
    {
        return $this->brand;
    }

    /**
     * Set model
     */
    public function setModel(Model $model = null): VehicleSearch
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     */
    public function getModel(): ? Model
    {
        return $this->model;
    }

    /**
     * Set country
     */
    public function setCountry(Country $country = null): VehicleSearch
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     */
    public function getCountry(): ? Country
    {
        return $this->country;
    }

    /**
     * Set city
     */
    public function setCity(City $city = null): VehicleSearch
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     */
    public function getCity(): ? City
    {
        return $this->city;
    }

    /**
     * Set bodyType
     */
    public function setBodyType(BodyType $bodyType = null): VehicleSearch
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
    public function setFuelType(FuelType $fuelType = null): VehicleSearch
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
    public function setColor(Color $color = null): VehicleSearch
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
     * Set transmission
     */
    public function setTransmission(Transmission $transmission = null): VehicleSearch
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
     */
    public function setClimateControl(ClimateControl $climateControl = null): VehicleSearch
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
    public function setDefects(Defects $defects = null): VehicleSearch
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
    public function setNextCheckYear(int $nextCheckYear = null): VehicleSearch
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
    public function setGearsNumber(int $gearsNumber = null): VehicleSearch
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
    public function setLastAdUpdate(\DateTime $lastAdUpdate): VehicleSearch
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
     * Set firstCountry
     */
    public function setFirstCountry(Country $firstCountry = null): VehicleSearch
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
     * Set sort type
     */
    public function setSortType(int $sortType = null): VehicleSearch
    {
        $this->sortType = $sortType;

        return $this;
    }

    /**
     * Get sort type
     */
    public function getSortType(): ? int
    {
        return $this->sortType;
    }
}
