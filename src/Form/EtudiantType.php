<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cin')
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('email')
            ->add('image', FileType::class, array(
                'label' => 'Choissiez votre fichier ',
                'data_class' => null))
            ->add('age')
            ->add('password')
            ->add('Ecole')
            ->add('Classe')
            ->add('Stage');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
