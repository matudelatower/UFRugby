<?php

namespace App\Form;

use App\Entity\Club;
use App\Entity\Torneo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TorneoType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'nombre' )
			->add( 'maximoTitularesPorEquipo',
				IntegerType::class,
				[
					'label' => 'Máximo titulares por equipo'
				] )
			->add( 'maximoSuplentesPorEquipo',
				IntegerType::class,
				[
					'label' => 'Máximo suplentes por equipo'
				] )
			->add( 'cargaIncidencias',
				ChoiceType::class,
				[
					'choices' => array(
						'Referee'     => 'referee',
						'Cada equipo' => 'equipo',
					),
				] )
			->add( 'sexo',
				ChoiceType::class,
				[
					'choices' => array(
						'Mixto'     => 'mixto',
						'Masculino' => 'fasculino',
						'Femenino'  => 'femenino',
					),
				] )
			->add( 'imageFile',
				VichImageType::class,
				[
					'label'        => 'Imagen',
					'required'     => false,
					'allow_delete' => true, // optional, default is true
				] )
			->add( 'clubOrganizador',
				EntityType::class,
				[
					'class'         => Club::class,
					'placeholder'   => 'Unión',
					'required'      => false,
					'label'         => 'Organizador',
					'query_builder' => function ( EntityRepository $er ) {
						return $er->createQueryBuilder( 'c' )
						          ->where( 'c.activo = true' );
					},
				] )
			->add( 'division',
				null,
				[
					'label' => 'División'
				] );

		$builder->addEventListener( FormEvents::PRE_SET_DATA,
			function ( FormEvent $event ) {
				$torneo = $event->getData();
				$form   = $event->getForm();

				// checks if the Product object is "new"
				// If no data is passed to the form, the data is "null".
				// This should be considered a new "Product"
				if ( $torneo->getId() ) {
					$form->add( 'activo' );
					$form->add( 'participanteTorneos',
						BootstrapCollectionType::class,
						[
							'entry_type'   => ParticipanteTorneoType::class,
							'allow_add'    => true,
							'allow_delete' => true,
							'by_reference' => false,
							'label'        => 'Participantes'
						] );
				}
			} );
	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( [
			'data_class'  => Torneo::class,
		] );
	}
}
