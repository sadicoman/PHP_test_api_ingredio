<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Aliment")
 */
class Aliment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $AlimentID;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $Nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $UserID;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $ImageUrl;

    // Getters et setters pour chaque propriété
}
