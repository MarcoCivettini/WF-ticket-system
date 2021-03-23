<?php

namespace App\Entity;

use App\Model\TaskStatus;
use App\Repository\TaskRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length="100")
     */
    private $description;

    /**
     *  @ORM\Column(type="int")ƒ
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", name="deadline_date")
     */
    private $deadlineDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function setStatus(TaskStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getDeadlineDate(): DateTime
    {
        return $this->deadlineDate;
    }

    public function setDeadlineDate(DateTime $date): self
    {
        $this->deadlineDate = $date;
        return $this;
    }
}
