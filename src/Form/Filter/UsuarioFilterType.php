<?php

namespace App\Form\Filter;

use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nombre de usuario'
            ])
            ->add('email')
            ->add('enabled', ChoiceType::class, [
                'label' => 'Activo',
                'choices' => [
                    'SI' => true,
                    'NO' => false
                ],
                'required' => false
            ])
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'choices' => [
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_CLUB' => 'ROLE_CLUB',
                    'ROLE_REFEREE' => 'ROLE_REFEREE',
                    'ROLE_REFEREE_ADMIN' => 'ROLE_REFEREE_ADMIN',
                    'ROLE_UNION' => 'ROLE_UNION'
                ]
            ])
//            ->add('persona')
            ->add('club',
                EntityType::class,
                [
                    'class' => 'App\Entity\Club',
                    'required' => false,
                    'placeholder' => 'Seleccionar Club',
                    'label' => 'Club *',
                    'attr' => ['class' => 'select2']
                ])
            ->add('buscar',
                SubmitType::class,
                array(
                    'attr' => array('class' => 'btn btn-primary'),
                ))
            ->add('limpiar',
                ResetType::class,
                array(
                    'attr' => array('class' => 'btn btn-default'),
                ));;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'required' => false
        ]);
    }
}
