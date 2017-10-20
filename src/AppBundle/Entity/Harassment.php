<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Class Harassment
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 *
 * @ApiResource()
 */
class Harassment
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"report_output"})
     */
    private $id;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     *
     * @Groups({"report_input", "report_output"})
     */
    private $datetime;

    /**
     * @var Location
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Location", inversedBy="harassment", cascade={"all"})
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     *
     * @Groups({"report_input", "report_output"})
     */
    private $location;

    /**
     * @var ArrayCollection|HarassmentType[]
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\HarassmentType")
     * @ORM\JoinTable(name="harassment_harassment_type",
     *      joinColumns={@ORM\JoinColumn(name="harassment_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="harassment_type_id", referencedColumnName="id")}
     *      )
     *
     * @Groups({"report_input", "report_output"})
     */
    private $types;

    /**
     * @var Report
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Report", mappedBy="harassment")
     */
    private $report;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"report_input", "report_output"})
     */
    private $note;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     *
     * @Groups({"report_output"})
     */
    private $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     *
     * @Groups({"report_output"})
     */
    private $updatedAt;

    /**
     * Harassment constructor.
     */
    public function __construct()
    {
        $this->types = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getDatetime(): DateTime
    {
        return $this->datetime;
    }

    /**
     * @param DateTime $datetime
     *
     * @return Harassment
     */
    public function setDatetime(DateTime $datetime): Harassment
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * @param Location $location
     *
     * @return Harassment
     */
    public function setLocation(Location $location): Harassment
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return HarassmentType[]|ArrayCollection
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param HarassmentType[]|ArrayCollection $types
     *
     * @return Harassment
     */
    public function setTypes($types): Harassment
    {
        $this->types = $types;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     *
     * @return Harassment
     */
    public function setCreatedAt(DateTime $createdAt): Harassment
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function updateCreatedAt()
    {
        $this->setCreatedAt(new DateTime());
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     *
     * @return Harassment
     */
    public function setUpdatedAt(DateTime $updatedAt): Harassment
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function updateUpdateAt()
    {
        $this->setUpdatedAt(new DateTime());
    }

    /**
     * @return Report
     */
    public function getReport(): Report
    {
        return $this->report;
    }

    /**
     * @param Report $report
     *
     * @return Harassment
     */
    public function setReport(Report $report): Harassment
    {
        $this->report = $report;

        return $this;
    }

    /**
     * @return string
     */
    public function getNote(): string
    {
        return $this->note;
    }

    /**
     * @param string $note
     *
     * @return Harassment
     */
    public function setNote(string $note): Harassment
    {
        $this->note = $note;

        return $this;
    }
}
