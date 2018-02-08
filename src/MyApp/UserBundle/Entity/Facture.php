<?php

namespace MyApp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity(repositoryClass="MyApp\UserBundle\Repository\FactureRepository")
 */
class Facture
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
     * @var float
     *
     * @ORM\Column(name="prixunitaire", type="float")
     */
    private $prixunitaire;

    /**
     * @var float
     *
     * @ORM\Column(name="prixtotal", type="float")
     */
    private $prixtotal;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_patient", type="string", length=255)
     */
    private $nomPatient;

    /**
     * @var string
     *
     * @ORM\Column(name="addressepatient", type="string", length=255)
     */
    private $addressepatient;


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
     * Set prixunitaire
     *
     * @param float $prixunitaire
     *
     * @return Facture
     */
    public function setPrixunitaire($prixunitaire)
    {
        $this->prixunitaire = $prixunitaire;

        return $this;
    }

    /**
     * Get prixunitaire
     *
     * @return float
     */
    public function getPrixunitaire()
    {
        return $this->prixunitaire;
    }

    /**
     * Set prixtotal
     *
     * @param float $prixtotal
     *
     * @return Facture
     */
    public function setPrixtotal($prixtotal)
    {
        $this->prixtotal = $prixtotal;

        return $this;
    }

    /**
     * Get prixtotal
     *
     * @return float
     */
    public function getPrixtotal()
    {
        return $this->prixtotal;
    }

    /**
     * Set nomPatient
     *
     * @param string $nomPatient
     *
     * @return Facture
     */
    public function setNomPatient($nomPatient)
    {
        $this->nomPatient = $nomPatient;

        return $this;
    }

    /**
     * Get nomPatient
     *
     * @return string
     */
    public function getNomPatient()
    {
        return $this->nomPatient;
    }

    /**
     * Set addressepatient
     *
     * @param string $addressepatient
     *
     * @return Facture
     */
    public function setAddressepatient($addressepatient)
    {
        $this->addressepatient = $addressepatient;

        return $this;
    }

    /**
     * Get addressepatient
     *
     * @return string
     */
    public function getAddressepatient()
    {
        return $this->addressepatient;
    }
}

