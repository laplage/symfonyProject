<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AccountType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, $this->updateConfiguration('Prénom', 'Votre prénom...'))
            ->add('lastName', TextType::class, $this->updateConfiguration('Nom', 'Votre nom...'))
            ->add('email', EmailType::class, $this->updateConfiguration('Email', 'Votre Adresse email ...'))
            ->add('picture', UrlType::class, $this->updateConfiguration('Photo de profil', 'Url de votre photo de profil...'))
            ->add('introduction', TextType::class, $this->updateConfiguration('Introduction', 'Présentez vous...'))
            ->add('description', TextareaType::class, $this->updateConfiguration('Présentation détaillée', 'Présentation détaillée'));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}