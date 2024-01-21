<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="GardeManger")
 */
class GardeManger {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $GardeMangerID;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="UserID", referencedColumnName="UserID")
     */
    private $UserID;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Aliment")
     * @ORM\JoinColumn(name="AlimentID", referencedColumnName="AlimentID")
     */
    private $AlimentID;

    /**
     * @ORM\Column(type="integer")
     */
    private $Quantite;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('g', 'l', 'pcs', 'cs', 'cc', 'kg', 'ml', 'tasse', 'pincée')")
     */
    private $Unite;

    // Getters et Setters pour chaque propriété
}
