<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RendezVous
 *
 * @ORM\Table(name="rendez_vous")
 * @ORM\Entity(repositoryClass="MyApp\UserBundle\Repository\RendezVousRepository")
 */
class RendezVous
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="cabinet", type="string", length=255)
     */
    private $cabinet;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_docteur", type="string", length=255)
     */
    private $nomDocteur;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return RendezVous
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set cabinet
     *
     * @param string $cabinet
     *
     * @return RendezVous
     */
    public function setCabinet($cabinet)
    {
        $this->cabinet = $cabinet;

        return $this;
    }

    /**
     * Get cabinet
     *
     * @return string
     */
    public function getCabinet()
    {
        return $this->cabinet;
    }

    /**
     * Set nomDocteur
     *
     * @param string $nomDocteur
     *
     * @return RendezVous
     */
    public function setNomDocteur($nomDocteur)
    {
        $this->nomDocteur = $nomDocteur;

        return $this;
    }

    /**
     * Get nomDocteur
     *
     * @return string
     */
    public function getNomDocteur()
    {
        return $this->nomDocteur;
    }
}

