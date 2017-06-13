<?php

namespace AppBundle\Entity;

use AppBundle\EntityInterface\ArchiveableInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubrideRepository")
 * @ORM\Table(name="subride")
 * @JMS\ExclusionPolicy("all")
 */
class Subride implements ArchiveableInterface
{
    /**
     * Numerische ID der Tour.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Ride", inversedBy="subrides")
     * @ORM\JoinColumn(name="ride_id", referencedColumnName="id")
     * @JMS\Expose
     */
    protected $ride;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @JMS\Expose
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @JMS\Expose
     */
    protected $description;

    /**
     * @ORM\Column(type="datetime")
     * @JMS\Expose
     */
    protected $dateTime;

    /**
     * @ORM\Column(type="datetime")
     * @JMS\Expose
     */
    protected $creationDateTime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @JMS\Expose
     */
    protected $location;

    /**
     * @ORM\Column(type="float")
     * @JMS\Expose
     */
    protected $latitude;

    /**
     * @ORM\Column(type="float")
     * @JMS\Expose
     */
    protected $longitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url()
     * @JMS\Expose
     */
    protected $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url()
     * @JMS\Expose
     */
    protected $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url()
     * @JMS\Expose
     */
    protected $url;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="subrides")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Subride", inversedBy="archive_subrides")
     * @ORM\JoinColumn(name="archive_parent_id", referencedColumnName="id")
     */
    protected $archiveParent;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isArchived = false;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $archiveDateTime;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="archive_subrides")
     * @ORM\JoinColumn(name="archive_user_id", referencedColumnName="id")
     */
    protected $archiveUser;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     */
    protected $archiveMessage;

    public function __construct()
    {
        $this->creationDateTime = new \DateTime();
        $this->archiveDateTime = new \DateTime();
    }

    public function __clone()
    {
        $this->setCreationDateTime(new \DateTime());
        $this->setArchiveDateTime(null);
        $this->setArchiveParent(null);
        $this->setArchiveUser(null);
        $this->setIsArchived(0);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(string $title): Subride
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setDescription(string $description): Subride
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\SerializedName("timestamp")
     * @JMS\Type("integer")
     */
    public function getTimestamp(): int
    {
        return $this->dateTime->format('U');
    }

    public function setDateTime(\DateTime $dateTime): Subride
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    public function setLocation(string $location): Subride
    {
        $this->location = $location;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLatitude(float $latitude): Subride
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLongitude(float $longitude): Subride
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setFacebook(string $facebook = null): Subride
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setTwitter(string $twitter = null): Subride
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setUrl(string $url = null): Subride
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

   public function setRide(Ride $ride = null): Subride
    {
        $this->ride = $ride;

        return $this;
    }

    public function getRide(): Ride
    {
        return $this->ride;
    }

    public function setUser(User $user = null): Subride
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setCreationDateTime(\DateTime $creationDateTime): Subride
    {
        $this->creationDateTime = $creationDateTime;

        return $this;
    }

    public function getCreationDateTime(): \DateTime
    {
        return $this->creationDateTime;
    }

    public function getTime(): \DateTime
    {
        return $this->dateTime;
    }

    /** @deprecated  */
    public function setTime(\DateTime $time): Subride
    {
        $this->dateTime = new \DateTime($this->dateTime->format('Y-m-d') . ' ' . $time->format('H:i:s'));
    }

    public function setIsArchived(bool $isArchived): ArchiveableInterface
    {
        $this->isArchived = $isArchived;

        return $this;
    }

    public function getIsArchived(): bool
    {
        return $this->isArchived;
    }

    public function setArchiveDateTime(\DateTime $archiveDateTime): ArchiveableInterface
    {
        $this->archiveDateTime = $archiveDateTime;

        return $this;
    }

    public function getArchiveDateTime(): \DateTime
    {
        return $this->archiveDateTime;
    }

    public function setArchiveParent(ArchiveableInterface $archiveParent): ArchiveableInterface
    {
        $this->archiveParent = $archiveParent;

        return $this;
    }

    public function getArchiveParent(): ArchiveableInterface
    {
        return $this->archiveParent;
    }

    public function setArchiveUser(User $archiveUser): ArchiveableInterface
    {
        $this->archiveUser = $archiveUser;

        return $this;
    }

    public function getArchiveUser(): User
    {
        return $this->archiveUser;
    }

    public function setArchiveMessage(string $archiveMessage): ArchiveableInterface
    {
        $this->archiveMessage = $archiveMessage;

        return $this;
    }

    public function getArchiveMessage(): string
    {
        return $this->archiveMessage;
    }

    public function archive(User $user): ArchiveableInterface
    {
        $archivedSubride = clone $this;

        $archivedSubride
            ->setIsArchived(true)
            ->setArchiveDateTime(new \DateTime())
            ->setArchiveParent($this)
            ->setArchiveUser($user)
            ->setArchiveMessage($this->archiveMessage);

        $this->archiveMessage = '';

        return $archivedSubride;
    }
}
