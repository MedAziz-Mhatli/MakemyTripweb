<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\Hotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class ChambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type',ChoiceType::class,array(

                'choices'=> array('Single'=>'Single','Double'=>'Double'),'expanded'=>true
            ))
            ->add('vue',ChoiceType::class,array(

                'choices'=> array('Normal'=>'Normal','Sur mer'=>'Sur mer','Sur piscine'=>'Sur piscine'),'expanded'=>true
            ))
            ->add('prixNuitee',\Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('hotel',
                EntityType::class,
                ['class'=>Hotel::class,
                    'choice_label'=>'nom','multiple'=>false,'expanded'=>false]);
            //->add('idHotel',\Symfony\Component\Form\Extension\Core\Type\TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chambre::class,
        ]);
    }
}
