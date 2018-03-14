<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClubJugadorType extends AbstractType {
	/**
	 * {@inheritdoc}
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder->add( 'club',
			EntityType::class,
			[
				'class'       => 'AppBundle\Entity\Club',
				'required'    => true,
				'placeholder' => 'Seleccionar Club',
				'label'       => 'Club *'
			] )
		        ->add( 'division',
			        EntityType::class,
			        [
				        'label'    => 'Categoría',
				        'class'    => 'AppBundle\Entity\Division',
				        'required' => false
			        ] )
		        ->add( 'consentimiento',
			        CheckboxType::class,
			        [
				        'label'    => 'Estoy de Acuerdo',
				        'required' => true
			        ] );
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'AppBundle\Entity\ClubJugador'
		) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix() {
		return 'appbundle_clubjugador';
	}


}
