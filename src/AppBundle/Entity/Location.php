<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Class Location
 *
 * @ApiResource()
 *
 * @ORM\Entity()
 */
class Location
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"report_output"})
     */
    private $id;

    /**
     * @var Harassment
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Harassment", mappedBy="location")
     */
    private $harassment;

    /**
     * @var double
     *
     * @ORM\Column(type="decimal", precision=10, scale=6)
     *
     * @Groups({"report_input", "report_output"})
     */
    private $longitude;

    /**
     * @var double
     *
     * @ORM\Column(type="decimal", precision=10, scale=6)
     *
     * @Groups({"report_input", "report_output"})
     */
    private $latitude;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Harassment
     */
    public function getHarassment(): Harassment
    {
        return $this->harassment;
    }

    /**
     * @param Harassment $harassment
     *
     * @return Location
     */
    public function setHarassment(Harassment $harassment): Location
    {
        $this->harassment = $harassment;

        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     *
     * @return Location
     */
    public function setLongitude(float $longitude): Location
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     *
     * @return Location
     */
    public function setLatitude(float $latitude): Location
    {
        $this->latitude = $latitude;

        return $this;
    }
}
