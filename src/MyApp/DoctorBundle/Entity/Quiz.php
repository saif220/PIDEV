<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 20/02/2018
 * Time: 14:44
 */

namespace MyApp\DoctorBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * quiz
 * @ORM\Entity()
 * @ORM\Table(name="quiz")
 */
class Quiz
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
     * @ORM\Column(name="age", type="string", length=255)
     */
    private $age;


    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255)
     */
    private $sexe;


    /**
     * @var string
     *
     * @ORM\Column(name="douleur", type="string", length=255)
     */
    private $douleur;


    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

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
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param string $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param string $sexe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }

    /**
     * @return string
     */
    public function getDouleur()
    {
        return $this->douleur;
    }

    /**
     * @param string $douleur
     */
    public function setDouleur($douleur)
    {
        $this->douleur = $douleur;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }




}