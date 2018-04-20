<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(
     *     message="Podaj nazwę"
     * )
     * @Assert\Regex(
     *     pattern="/^[A-ZĄŻŹŚĘÓŃ](\w| )+/",
     *     message="Niedozwolona wartość. Nazwa musi zaczynać się od dużej litery"
     * )
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @Assert\NotBlank(
     *     message="Podaj cenę"
     * )
     * @Assert\Range(
     *      min = 0.01,
     *      minMessage = "Minimalna wartość to 0.01"
     * )
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    private $price;

    /**
     * @Assert\NotBlank(
     *     message="Podaj opis"
     * )
     * @Assert\Regex(
     *     pattern="/^[A-ZŻŹĄŚĘĆÓŃ]\w+/",
     *     message="Niedozwolona wartość. Zacznij z dużej litery"
     * )
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Assert\NotBlank(
     *     message="Podaj ilość"
     * )
     * @Assert\Range(
     *      min = 1,
     *      max = 1000,
     *      minMessage = "Minimalna ilość to 1",
     *      maxMessage = "Nie więcej niż 1000"
     * )
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }


    //Getters and setters

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

}
