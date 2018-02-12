<?php

namespace MyApp\DoctorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cabinet
 *
 * @ORM\Table(name="cabinet")
 * @ORM\Entity(repositoryClass="MyApp\DoctorBundle\Repository\CabinetRepository")
 */
class Cabinet
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
     * @var string
     *
     * @ORM\Column(name="nom_docteur", type="string", length=255)
     */
    private $nomDocteur;

    /**
     * @var string
     *
     * @ORM\Column(name="addresse", type="string", length=255)
     */
    private $addresse;

    /**
     * @var int
     *
     * @ORM\Column(name="tel", type="integer")
     */
    private $tel;


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
     * Set nomDocteur
     *
     * @param string $nomDocteur
     *
     * @return Cabinet
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

    /**
     * Set addresse
     *
     * @param string $addresse
     *
     * @return Cabinet
     */
    public function setAddresse($addresse)
    {
        $this->addresse = $addresse;

        return $this;
    }

    /**
     * Get addresse
     *
     * @return string
     */
    public function getAddresse()
    {
        return $this->addresse;
    }

    /**
     * Set tel
     *
     * @param integer $tel
     *
     * @return Cabinet
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return int
     */
    public function getTel()
    {
        return $this->tel;
    }
}

