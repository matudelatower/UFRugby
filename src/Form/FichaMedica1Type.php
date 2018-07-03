<?php

namespace App\Form;

use App\Entity\FichaMedica;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FichaMedica1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prestador')
            ->add('numeroAfiliado')
            ->add('tieneCobertura')
            ->add('doctor')
            ->add('matricula')
            ->add('grupoSanguineo')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FichaMedica::class,
        ]);
    }
}
