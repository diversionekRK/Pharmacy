<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
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
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^\w+/",
     *     message="Niedozwolona wartość"
     * )
     * @ORM\Column(type="text")
     */
    protected $task;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dueDate;

    public function getTask()
    {
        return $this->task;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function setTask($task)
    {
        $this->task = $task;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTime $dueDate = null)
    {
        $this->dueDate = $dueDate;
    }

 //   /**
 //    * @Assert\Expression(
 //    *     "this.getTask() in ['elo', 'ole']",
 //    *     message="If this is a tech post, the category should be either php or symfony!"
 //    * )
 //    */
 //   public $isTechnicalPost;

}
