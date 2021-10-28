<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 * @ORM\Table(name="employees")
 * @ORM\HasLifecycleCallbacks()
 */
class Employee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $employee_number;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="employee", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getEmployeeNumber(): ?string
    {
        return $this->employee_number;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setTimestamps(): void
    {
        $timestamp = new \DateTimeImmutable('now');

        $this->updated_at = $timestamp;

        if (is_null($this->created_at)) {
            $this->created_at = $timestamp;
        }
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->user->setRoles(['ROLE_USER', 'ROLE_EMPLOYEE']);
        $this->employee_number = random_int(1000, 9999);
    }
}
