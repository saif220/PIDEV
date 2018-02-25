<?php

namespace MyApp\DoctorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class CabinetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomDocteur')
            ->add('addresse')
            ->add('latitude')
            ->add('longitude')
            ->add('specialite',ChoiceType::class,array('choices'=>array(
                'Generaliste'=>'Generaliste',
                'Cardilogie'=>'Cardiologie',
                'Dermatologie'=>'Dermatologie',
                'Gastro-entérologie'=>'Gastro-entérologie',
                'Gynécologie'=>'Gynécologie',
                'Neurologie'=>'Neurologie',
                'Ophtalmologie'=>'Ophtalmologie',
                'Orthopédie'=>'Orthopédie',
                'Pédiatrie'=>'Pédiatrie',
                'Radiologie'=>'Radiologie',),
            ))
            ->add('tel')

            ->add('devisFile', VichFileType::class, array(
                'required' => false,
                'allow_delete' => true // not mandatory, default is true
                 // not mandatory, default is true
            ));
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyApp\DoctorBundle\Entity\Cabinet'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'myapp_doctorbundle_cabinet';
    }


}
