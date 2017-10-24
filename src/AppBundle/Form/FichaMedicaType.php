<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FichaMedicaType extends AbstractType {
	/**
	 * {@inheritdoc}
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'tieneCobertura',
				ChoiceType::class,
				[
					'label'    => 'Tiene Cobertura Médica?',
					'expanded' => true,
					'multiple' => false,
					'choices'  => array( 'Sí' => true, 'No' => false ),
				] )
			->add( 'prestador',
				TextType::class,
				[
					'required' => true,
					'attr'     => [ 'class' => 'tieneCobertura' ]
				] )
			->add( 'numeroAfiliado',
				TextType::class,
				[
					'label' => 'Nº Afiliado',
					'required' => true,
					'attr'     => [ 'class' => 'tieneCobertura' ]
				] )
			->add( 'grupoSanguineo',
				EntityType::class,
				[
					'label'    => 'Grupo Sanguíneo *',
					'class'    => 'AppBundle\Entity\GrupoSanguineo',
					'required' => true,
					'placeholder' => 'Seleccionar'
				] );
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'AppBundle\Entity\FichaMedica'
		) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix() {
		return 'appbundle_fichamedica';
	}


}
