<?php

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class ReadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',\Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('description',\Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('adresse',\Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('categorie',\Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('nbchdispo',\Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('email',\Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('telephone',\Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('rate',\Symfony\Component\Form\Extension\Core\Type\TextType::class)
         ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
