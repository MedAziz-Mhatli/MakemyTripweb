<?php

namespace App\Form;

use App\Entity\Facture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateFacture')
            ->add('remiseFacture')
            ->add('totalFacture')
            ->add('typeFature', ChoiceType::class, array(
                'choices' => array(
                    'Vol' => 'Vol',
                    'vehicule' => 'vehicule',
                    'Chambre' => 'Chambre',


                )

            ));


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
