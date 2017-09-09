<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
			->add( 'prestador' )
			->add( 'numeroAfiliado' )
			->add( 'indiceTorg' )
			->add( 'grupoSanguineo' );
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
