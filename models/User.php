<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="User")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $UserID;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $Pseudo;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $Email;

    /**
     * @ORM\Column(type="string")
     */
    private $MotDePasse;

    // Plus de getters et setters...
}
