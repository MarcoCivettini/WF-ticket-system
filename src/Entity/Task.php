<?php

namespace App\Entity;

use App\Model\TaskStatus;
use App\Repository\TaskRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(type="string", length=100)
     */
    private $description;

    /**
     *  @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", name="deadline_date")
     */
    private $deadlineDate;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="tasks")
     * @ORM\JoinTable(name="users_tasks")
     */
    private $users;

    /**
     * @ORM\Column(type="integer")
     */
    private $project_id;
    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="tasks")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

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

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
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

    public function addUser(User $user): self
    {
        $this->users->add($user);
        return $this;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function getProject()
    {
        return $this->project;
    }
    public function setProject(Project $project): self
    {
        $this->project = $project;
        return $this;
    }
}
