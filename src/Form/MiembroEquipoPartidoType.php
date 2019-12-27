<?php

namespace App\Form;

use App\Entity\Jugador;
use App\Entity\MiembroEquipoPartido;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class MiembroEquipoPartidoType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {

		$club = $options['equipo'];

		$builder
//			->add( 'jugador',
//				EntityType::class,
//				[
//					'class'         => Jugador::class,
//					'query_builder' => function ( EntityRepository $er ) use ( $club ) {
//						return $er->getJugadoresByClub( $club );
//					},
//				] )
			->add( 'jugador',
				Select2EntityType::class,
				[
					'class'         => Jugador::class,
					'placeholder'   => 'Buscar Jugador Por nombre y apellido',
//					'property'     => 'nombre',
//					'req_params' => ['club' => 'parent.children[equipoPartido]'],
					'remote_route'  => 'ajax_get_jugadores',
					'remote_params' => [ 'club' => $club->getId() ]
				] )
//			->add( 'titular' )
//			->add( 'suplente' )
		;
	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( [
			'data_class' => MiembroEquipoPartido::class,
			'equipo'     => null
		] );
	}
}
