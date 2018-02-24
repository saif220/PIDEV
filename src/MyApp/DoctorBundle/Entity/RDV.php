<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 16/02/2018
 * Time: 12:03
 */

namespace MyApp\DoctorBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * RDV
 * @ORM\Entity()
 * @ORM\Table(name="rdv")
 */


class RDV
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
     * @ORM\Column(name="nompatient", type="string", length=255, nullable=true)
     */
private $nompatient;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
private $description;

    /**
     * @var string
     * @ORM\Column(name="day", type="string", length=255)
     */
    private $day;


    /**
     * @var string
     * @ORM\Column(name="hour", type="string", length=255)
     */
    private $hour;

    /**
     * @var int
     *
     * @ORM\Column(name="numtel", type="integer", nullable=true)
     */
private $num_tel;




    /**
     * @var string
     * @ORM\Column(name="doctorname", type="string", length=255)
     */
    private $doctorname;


    /**
     * Many rdv have One user.
     * @ORM\ManyToOne(targetEntity="MyApp\UserBundle\Entity\User")
     */
    private $userid;



    /**
     * @ORM\Column(type="date", length=255)
     */
    private $date;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNompatient()
    {
        return $this->nompatient;
    }

    /**
     * @param string $nompatient
     */
    public function setNompatient($nompatient)
    {
        $this->nompatient = $nompatient;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param string $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * @return string
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @param string $hour
     */
    public function setHour($hour)
    {
        $this->hour = $hour;
    }

    /**
     * @return int
     */
    public function getNumTel()
    {
        return $this->num_tel;
    }

    /**
     * @param int $num_tel
     */
    public function setNumTel($num_tel)
    {
        $this->num_tel = $num_tel;
    }

    /**
     * @return string
     */
    public function getDoctorname()
    {
        return $this->doctorname;
    }

    /**
     * @param string $doctorname
     */
    public function setDoctorname($doctorname)
    {
        $this->doctorname = $doctorname;
    }

    /**
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }









}