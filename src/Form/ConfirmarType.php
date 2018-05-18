<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfirmarType extends AbstractType {
	/**
	 * {@inheritdoc}
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {

		if ( $options['confirmarClub'] ) {
			$builder->add( 'confirmadoClub',
				CheckboxType::class,
				[
					'label'    => 'Confirmar',
					'required' => true
				] );
		}
		if ( $options['confirmarUnion'] ) {
			$builder->add( 'confirmadoUnion',
				CheckboxType::class,
				[
					'label'    => 'Confirmar',
					'required' => true
				] );
		}

	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class'     => 'App\Entity\ClubJugador',
			'confirmarUnion' => false,
			'confirmarClub'  => false,
		) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix() {
		return 'App_clubjugador_confirmar';
	}


}
