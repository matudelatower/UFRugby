<?php

namespace App\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\Query\Expr;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

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
			->add( 'concepto' )
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
				] );

		$builder->addEventListener( FormEvents::PRE_SET_DATA,
			function ( FormEvent $event ) use ( $club ) {
				$pago = $event->getData();
				$form = $event->getForm();

				// checks if the Product object is "new"
				// If no data is passed to the form, the data is "null".
				// This should be considered a new "Product"
				if ( ! $pago || null === $pago->getId() ) {
					$form->
					add( 'jugador',
						EntityType::class,
						[
							'class'         => 'App\Entity\Jugador',
							'required'      => true,
							'placeholder'   => 'Seleccionar Jugador',
							'label'         => 'Jugador *',
							'attr'          => [ 'class' => 'select2' ],
							'query_builder' => function ( EntityRepository $er ) use ( $club ) {
								return $er->createQueryBuilder( 'j' )
								          ->innerJoin( 'j.clubJugador', 'cj' )
								          ->leftJoin( 'j.clubJugador',
									          'cj2',
									          Expr\Join::WITH,
									          'j = cj2.jugador AND cj.id <  cj2.id' )
								          ->where( 'cj2.id IS NULL' )
								          ->andWhere( 'cj.club = :club' )
								          ->setParameter( 'club', $club )
								          ->andWhere( 'cj.confirmadoUnion = true' );
							},

						] );
				}
			} );
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
