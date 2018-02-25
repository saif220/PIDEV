<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 21/02/2018
 * Time: 20:23
 */

namespace MyApp\ShopBundle\Form;

use blackknight467\StarRatingBundle\Form\RatingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class RatingTypes extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('rating',RatingType::class, ['label'=>'Rating']
        );
    }
}
