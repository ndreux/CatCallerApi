<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 *
 * @ApiResource(
 *     attributes={
 *         "normalization_context"={"groups"={"user_read"}},
 *         "denormalization_context"={"groups"={"user_write"}},
 *         "filters"={"user.search"}
 *     },
 *     collectionOperations={"get"={"method"="GET"}, "post"={"method"="POST"}},
 *     itemOperations={
 *          "get"={"method"="GET"},
 *          "put"={"method"="PUT"}
 *     }
 * )
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity("email")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    const STATUS_ACTIVE   = 1;
    const STATUS_INACTIVE = 2;

    /**
     * @var int $id
     *
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     *
     * @Groups({"user_read"})
     */
    protected $id;

    /**
     *
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Length(max=255)
     *
     * @Groups({"user_read", "user_write"})
     */
    protected $email;

    /**
     * Password
     *
     * @var string $password
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $password;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     *
     * @Assert\Length(min=4, max=255)
     *
     * @Groups({"user_write"})
     */
    protected $plainPassword;

    /**
     * @var int $status
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     * @Assert\NotNull()
     * @Assert\Type(type="int")
     *
     * @Groups({"user_read", "user_write"})
     */
    protected $status;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Groups({"user_read"})
     */
    protected $lastConnectedAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @Groups({"user_read"})
     */
    protected $updatedAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @Groups({"user_read"})
     */
    protected $createdAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->status = self::STATUS_ACTIVE;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return null|string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return null|string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * @return null|DateTime
     */
    public function getLastConnectedAt()
    {
        return $this->lastConnectedAt;
    }

    /**
     * @param DateTime $lastConnectedAt
     */
    public function setLastConnectedAt(DateTime $lastConnectedAt)
    {
        $this->lastConnectedAt = $lastConnectedAt;
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
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
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
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @ORM\PrePersist()
     */
    public function updateCreatedAt()
    {
        $this->setCreatedAt(new DateTime());
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return string[] The user roles
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }
}
