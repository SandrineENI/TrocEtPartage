<?php

namespace App\Form;

use App\Entity\EditoImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditoImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fichier', FileType::class, [
                'label' => 'Image',
                'mapped' => false, // gérée manuellement dans le contrôleur
                'required' => false,
            ])
            ->add('legende', TextType::class, [
                'label' => 'Légende (facultative)',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EditoImage::class,
        ]);
    }
}
