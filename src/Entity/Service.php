<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 * @ORM\Table(name="services")
 * @ORM\HasLifecycleCallbacks()
 */
class Service
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=18)
     */
    private $folio;

    /**
     * @ORM\ManyToOne(targetEntity=ServiceType::class, inversedBy="services")
     * @ORM\JoinColumn(nullable=false)
     */
    private $service_type;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="services")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=ServiceStage::class, inversedBy="services")
     * @ORM\JoinColumn(nullable=false)
     */
    private $service_stage;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $details;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_billable;

    /**
     * @ORM\Column(type="boolean", options={ "default": false })
     */
    private $is_served;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $due_date;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $served_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFolio(): ?string
    {
        return $this->folio;
    }

    public function getServiceType(): ?ServiceType
    {
        return $this->service_type;
    }

    public function setServiceType(?ServiceType $service_type): self
    {
        $this->service_type = $service_type;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getServiceStage(): ?ServiceStage
    {
        return $this->service_stage;
    }

    public function setServiceStage(?ServiceStage $service_stage): self
    {
        $this->service_stage = $service_stage;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getIsBillable(): ?bool
    {
        return $this->is_billable;
    }

    public function setIsBillable(bool $is_billable): self
    {
        $this->is_billable = $is_billable;

        return $this;
    }

    public function getIsServed(): ?bool
    {
        return $this->is_served;
    }

    public function setIsServed(bool $is_served): self
    {
        $this->is_served = $is_served;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->created_at;
    }

    public function getDueDate(): ?\DateTimeImmutable
    {
        return $this->due_date;
    }

    public function setDueDate(\DateTimeImmutable $due_date): self
    {
        $this->due_date = $due_date;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist(): void
    {
        $this->folio = strtoupper(uniqid());
        $this->is_billable = ($this->client->getRfc() !== null);
        
        $this->created_at = new \DateTimeImmutable('now');
    }

    public function getServedAt(): ?\DateTimeImmutable
    {
        return $this->served_at;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(): void
    {
        if ($this->is_served) {
            $this->served_at = new \DateTimeImmutable('now');
        }
    }
}
