<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Class Report
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 *
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"report_output"}},
 *     "denormalization_context"={"groups"={"report_input"}}
 * })
 */
class Report
{

    const TYPE_VICTIM  = 1;
    const TYPE_WITNESS = 2;

    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"report_output"})
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @Groups({"report_input", "report_output"})
     */
    private $reporter;

    /**
     * @var Harassment
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Harassment", inversedBy="report", cascade={"all"})
     * @ORM\JoinColumn(name="harassment_id", referencedColumnName="id")
     *
     * @Groups({"report_input", "report_output"})
     */
    private $harassment;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     *
     * @Groups({"report_input", "report_output"})
     */
    private $type;

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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getReporter(): User
    {
        return $this->reporter;
    }

    /**
     * @param User $reporter
     *
     * @return Report
     */
    public function setReporter(User $reporter): Report
    {
        $this->reporter = $reporter;

        return $this;
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
     * @return Report
     */
    public function setHarassment(Harassment $harassment): Report
    {
        $this->harassment = $harassment;

        return $this;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return Report
     */
    public function setType(int $type): Report
    {
        $this->type = $type;

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
     * @return Report
     */
    public function setCreatedAt(DateTime $createdAt): Report
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
     * @return Report
     */
    public function setUpdatedAt(DateTime $updatedAt): Report
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
}
