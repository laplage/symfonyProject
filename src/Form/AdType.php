<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, $this->updateConfiguration('Titre', 'Tapez un titre pour votre annonce'))
            ->add('slug', TextType::class, $this->updateConfiguration('Slug', 'Tapez une url pour votre annonce'))
            ->add('price', MoneyType::class, $this->updateConfiguration('Prix', 'Indiquez le prix que vous voulez par nuit '))
            ->add('introduction', TextType::class, $this->updateConfiguration('Introduction', 'Donnez une description de l\'annonce '))
            ->add('content', TextareaType::class, $this->updateConfiguration('contenu', 'Tapez une description détaillé de votre annonce'))
            ->add('coverImage', FileType::class)
            ->add('rooms', IntegerType::class, $this->updateConfiguration('Nombre de chambre', 'le nombre de chambre disponible'))
            ->add(
                'images',
                FileType::class,
                [
                    'label' => false,
                    'multiple' => true,
                    'mapped' => false,
                    'required' => false
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
    // public function updateConfiguration($label, $placeholder)
    // {
    //     return [
    //         'label' => $label,
    //         'attr' => [
    //             'placeholder' => $placeholder
    //         ]
    //     ];
    // }
}