<?php

namespace App\Form;

use App\Entity\ParticipanteTorneo;
use App\Entity\Partido;
use App\Entity\Referee;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartidoType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'fecha',
				DateType::class,
				[
					'widget' => 'single_text',
					'html5'  => true
				] )
			->add( 'hora',
				TimeType::class,
				[
					'widget' => 'single_text',
					'html5'  => true
				] )
			->add( 'sede' )
			->add( 'observaciones' )
			->add( 'activo' )
			->add( 'local',
				EntityType::class,
				[
					'mapped' => false,
					'class'  => ParticipanteTorneo::class,
					'data'   => $options['local']
				] )
			->add( 'visitante',
				EntityType::class,
				[
					'mapped' => false,
					'class'  => ParticipanteTorneo::class,
					'data'   => $options['visitante']
				] )
			->add( 'referee',
				EntityType::class,
				[
					'class'         => Referee::class,
					'placeholder'   => '(Sin Designar)',
					'query_builder' => function ( EntityRepository $er ) {
						return $er->createQueryBuilder( 'r' )
						          ->where( 'r.activo = true' );
					},
					'required'      => false
				] );

		$builder->addEventListener( FormEvents::PRE_SET_DATA,
			function ( FormEvent $event ) {
				$partido = $event->getData();
				$form    = $event->getForm();

				// checks if the Product object is "new"
				// If no data is passed to the form, the data is "null".
				// This should be considered a new "Product"
				if ( ! $partido || null === $partido->getId() ) {
					$form->add( 'local',
						EntityType::class,
						[
							'mapped' => false,
							'class'  => ParticipanteTorneo::class
						] );
					$form->add( 'visitante',
						EntityType::class,
						[
							'mapped' => false,
							'class'  => ParticipanteTorneo::class
						] );

				}
			} );

	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( [
			'data_class' => Partido::class,
			'local'      => null,
			'visitante'  => null,
		] );
	}
}
