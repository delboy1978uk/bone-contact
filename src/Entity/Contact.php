<?php declare(strict_types=1);

namespace Bone\Contact\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Contact
 * @package Bone\Contact\Entity
 * @ORM\Entity
 */
class Contact
{
    /**
     * @var int $id
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string $name
     * @ORM\Column(type="string",length=50)
     */
    private $name;

    /**
     * @var string $email
     * @ORM\Column(type="string",length=50)
     */
    private $email;

    /**
     * @var string $telephone
     * @ORM\Column(type="string",length=50, nullable=true)
     */
    private $telephone;

    /**
     * @var string $subject
     * @ORM\Column(type="string",length=50)
     */
    private $subject;

    /**
     * @var string $message
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @var DateTime $dateReceived
     * @ORM\Column(type="datetime")
     */
    private $dateReceived;

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
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return DateTime
     */
    public function getDateReceived(): DateTime
    {
        return $this->dateReceived;
    }

    /**
     * @param DateTime $dateReceived
     */
    public function setDateReceived(DateTime $dateReceived): void
    {
        $this->dateReceived = $dateReceived;
    }
}
