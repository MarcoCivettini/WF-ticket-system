<?php

namespace App\Entity;

use App\Model\UserRole;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $password;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $team_id;
    /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="users")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id", nullable=true)
     */
    private $team;

    /**
     * @ORM\Column(type="integer")
     */
    private $role;

    /*
    * @ORM\ManyToMany(targetEntity="Task", inversedBy="users")
    */
    private $tasks;

    /**
     * Project linked to the PM.
     * if use Inheritance Mapping i can extend the User entity
     * and declare this property only on the SuperClass (ProductManager extends User)
     * @ORM\OneToMany(targetEntity="Project", mappedBy="user")
     */
    private $projects;

    
    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function setTeamId(int $team_id): self
    {
        $this->team_id = $team_id;
        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }
    public function setTeam(Team $team): self
    {
        $this->team = $team;
        return $this;
    }

    public function getRole(): int
    {
        return $this->role;
    }

    public function setRole(int $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function addProject(Project $project): self
    {
        $this->projects->add($project->setUser($this));
        return $this;
    }

    public function getProjects()
    {
        return $this->projects;
    }

    public function addTask(Task $task): self
    {
        $this->tasks->add($task);
        return $this;
    }

    public function getTasks()
    {
        return $this->tasks;
    }
}
