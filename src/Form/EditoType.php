<?php

namespace App\Form;

use App\Entity\Edito;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datePublication', null, [
                'widget' => 'single_text',
            ])
            ->add('titre', TextType::class, [
                'label' => 'Titre de l’édito',
            ])
            ->add('contenu', TextareaType::class, [
                'label' => 'Contenu',
                'required' => false,
            ])
            ->add('photoPrincipale', FileType::class, [
                'label' => 'Photo principale',
                'mapped' => false,
                'required' => false,
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => EditoImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Galerie de photos associées',
                'prototype' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Edito::class,
        ]);
    }
}
