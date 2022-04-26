<?php

namespace App\Form;

use App\Entity\Vol;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



  

class VolType extends AbstractType 
{
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder
                ->add('depart_vol')
                ->add('destination_vol')
                ->add('date_departVol')
                ->add('date_retourVol')
                ->add('nb_escalesVol')
                ->add('prixVol')
                
            
            ;
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vol::class,
        ]);
    }
}