<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
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
			->add( 'categoria' )
			->add( 'posicionHabitual' )
			->add( 'posicionAlternativa' )
			->add( 'segundaPosicionAlternativa' )
			->add( 'condicionJugador' )
			->add( 'club', ClubJugadorType::class )
			->add( 'fichaMedica', FichaMedicaType::class );
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'AppBundle\Entity\Jugador'
		) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix() {
		return 'appbundle_jugador';
	}


}
