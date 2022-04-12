<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('nomuser')
            // ->add('dateReclamation')
            ->add('emailReclamation')
            // ->add('etatReclamation')
            // ->add('idClient');
            ->add(
                'desriptionReclamation',
                TextareaType::class,
                array('attr' => array('rows' => '500', 'cols' => '120', 'style' => 'height:130px;resize:none'))

            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
