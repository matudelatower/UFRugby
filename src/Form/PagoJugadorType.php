<?php

namespace App\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagoJugadorType extends AbstractType {
	/**
	 * {@inheritdoc}
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {

		$club = $options['club'];

		$builder
			->add( 'fecha',
				DateType::class,
				array(
					'widget' => 'single_text',
					'html5'  => true
				) )
			->add( 'monto' )
			->add( 'mes',
				ChoiceType::class,
				[
					'choices' =>
						array(
							'Enero'      => 'Enero',
							'Febrero'    => 'Febrero',
							'Marzo'      => 'Marzo',
							'Abril'      => 'Abril',
							'Mayo'       => 'Mayo',
							'Junio'      => 'Junio',
							'Julio'      => 'Julio',
							'Agosto'     => 'Agosto',
							'Septiembre' => 'Septiembre',
							'Octubre'    => 'Octubre',
							'Noviembre'  => 'Noviembre',
							'Diciembre'  => 'Diciembre',
						),
				] )
			->add( 'jugador',
				EntityType::class,
				[
					'class'         => 'App\Entity\Jugador',
					'required'      => true,
					'placeholder'   => 'Seleccionar Jugador',
					'label'         => 'Jugador *',
					'attr'          => [ 'class' => 'select2' ],
					'query_builder' => function ( EntityRepository $er ) use ( $club ) {
						return $er->createQueryBuilder( 'j' )
						          ->join( 'j.clubJugador', 'cj' )
						          ->join( 'cj.club', 'c' )
						          ->where( 'c = :club' )
						          ->andWhere( 'cj.confirmadoUnion = true' )
						          ->setParameter( 'club', $club );
					},

				] );
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'App\Entity\PagoJugador',
			'club'       => null
		) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix() {
		return 'App_pagojugador';
	}


}
