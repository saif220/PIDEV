<?php

namespace MyApp\DoctorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Cabinet
 * @Vich\Uploadable
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
     * @var string
     *
     * @ORM\Column(name="specialite", type="string", length=255)
     */
    private $specialite;

    /**
     * @ORM\OneToOne(targetEntity="MyApp\UserBundle\Entity\User", cascade={"persist"})
     */
    protected $user;


    /**
     * @var int
     *
     * @ORM\Column(name="latitude", type="float")
     */
    private $latitude;


    /**
     * @var int
     *
     * @ORM\Column(name="longitude", type="float")
     */
    private $longitude;






    /**
     * @Vich\UploadableField(mapping="devis", fileNameProperty="devisName")
     *
     * @var File
     */
    private $devisFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $devisName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;




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

    /**
     * @return string
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * @param string $specialite
     */
    public function setSpecialite($specialite)
    {
        $this->specialite = $specialite;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $devis
     *
     * @return Cabinet
     */
    public function setDevisFile(File $devis = null)
    {
        $this->devisFile = $devis;

        if ($devis)
            $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    /**
     * @return File|null
     */
    public function getDevisFile()
    {
        return $this->devisFile;
    }

    /**
     * @param string $devisName
     *
     * @return Cabinet
     */
    public function setDevisName($devisName)
    {
        $this->devisName = $devisName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDevisName()
    {
        return $this->devisName;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }





}

