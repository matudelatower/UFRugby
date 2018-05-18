<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JugadorType extends AbstractType {
	/**
	 * {@inheritdoc}
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'peso' )
			->add( 'altura' )
			->add( 'dadoDeBaja' )
			->add( 'posicionHabitual',
				EntityType::class,
				[
					'required'    => true,
					'class'       => 'App\Entity\PosicionJugador',
					'placeholder' => 'Seleccionar Posición',
					'label'       => 'Posición Habitual *'
				] )
			->add( 'posicionAlternativa' )
			->add( 'segundaPosicionAlternativa' )
			->add( 'condicionJugador' )
			->add( 'clubJugador',
				CollectionType::class,

				[
					'entry_type' => ClubJugadorType::class,
					'label'      => '  ',
					'by_reference'  => false,

				] )
//			->add( 'fichaMedica',
//				CollectionType::class,
//				[
//					'entry_type' => FichaMedicaType::class,
//					'by_reference'  => false,
//
//				] )
		;
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'App\Entity\Jugador'
		) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix() {
		return 'App_jugador';
	}


}
