<?php

namespace App\Form;

use App\Entity\EquipoPartido;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipoPartidoType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {


		$club = null;
//		$maximoPorEquipo = $options['maximo_por_equipo'];
		if ( $options['local'] ) {
			$club = $options['data']->getPartido()->getLocal()->getEquipo()->getClub();
		} elseif ( $options['visitante'] ) {
			$club = $options['data']->getPartido()->getVisitante()->getEquipo()->getClub();
		}

		$builder
//			->add( 'equipo' )
			->add( 'miembroEquipoPartidos',
				BootstrapCollectionType::class,
				[
					'entry_type'    => MiembroEquipoPartidoType::class,
					'allow_add'     => true,
					'allow_delete'  => true,
					'by_reference'  => false,
					'label'         => 'Miembros del Equipo',
					'entry_options' => [ 'equipo' => $club ],
//					'max_items_add' => $maximoPorEquipo
				] )
			->add( 'confirmarEquipo',
				SubmitType::class,
				[
					'label' => 'Confirmar Equipo',
					'attr'  => [ 'class' => 'btn btn-primary btn-guardar' ]
				] );
	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( [
			'data_class' => EquipoPartido::class,
			'local'      => false,
			'visitante'  => false,
//			'maximo_por_equipo' => null
		] );
	}
}
