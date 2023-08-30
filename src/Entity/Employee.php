<?php

declare(strict_types=1);

namespace App\Entity;

use App\Infrastructure\Doctrine\TimestampTrait;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;


#[ORM\Entity]
#[ORM\Table(name: 'employee')]
#[UniqueEntity('email')]
class Employee
{
    use TimestampTrait;

    #[Type('integer')]
    #[NotBlank(groups: ['delete', 'read'])]
    #[Groups(["delete", "read"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[Type('string')]
    #[NotBlank(groups: ['create', 'update'])]
    #[Groups(["create", "update"])]
    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $firstname;

    #[Type('string')]
    #[NotBlank(groups: ['create', 'update'])]
    #[Groups(["create", "update"])]
    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $lastname;

    #[Type('string')]
    #[NotBlank(groups: ['create', 'update'])]
    #[Email()]
    #[Groups(["create", "update"])]
    #[ORM\Column(type: Types::STRING, length: 180, unique: true)]
    private string $email;

    #[NotBlank(groups: ['create', 'update'])]
    #[GreaterThanOrEqual('today')]
    #[Groups(["create", "update"])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private DateTime $hireDate;

    #[Type('integer')]
    #[NotBlank(groups: ['create', 'update'])]
    #[GreaterThan(100)]
    #[Groups(["create", "update"])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $salary;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        if (false !== filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;

            return $this;
        }

        throw new InvalidArgumentException('Invalid value of the email argument');
    }

    public function getHireDate(): DateTime
    {
        return $this->hireDate;
    }

    public function setHireDate(DateTime $hireDate): self
    {
        $this->hireDate = $hireDate;

        return $this;
    }

    public function getSalary(): int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'firstname' => $this->getFirstname(),
            'lastname' => $this->getLastname(),
            'email' => $this->getEmail(),
            'hireDate' => $this->getHireDate()->format('Y-m-d'),
            'salary' => $this->getSalary(),
        ];
    }
}