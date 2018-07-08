<?php

namespace App\Form\Filter;

use App\Entity\Categoria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BuscarJugadoresFilterType extends AbstractType {
	/**
	 * {@inheritdoc}
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'numeroIdentificacion',
				TextType::class,
				[
					'label' => 'Cédula'
				] )
			->add( 'nombre' )
			->add( 'apellido' )
			->add( 'posicion',
				EntityType::class,
				[
					'class'       => 'App\Entity\PosicionJugador',
					'placeholder' => 'Seleccionar Posición',
					'label'       => 'Posición'
				] )
			->add( 'club',
				EntityType::class,
				[
					'class'       => 'App\Entity\Club',
					'placeholder' => 'Seleccionar Club',
					'label'       => 'Club',
					'attr'        => [ 'class' => 'select2' ],
				] )
			->add( 'estadoFichaje',
				ChoiceType::class,
				[
					'choices'     => [
						'Pendiente Unión' => 'confirmadoClub',
						'Pendiente Club'  => 'confirmadoUnion'
//						se pone al reves los valores porque busca lo contrario
					],
					'placeholder' => 'Seleccionar Estado',
					'required'    => false
				] )
			->add( 'categoria',
				EntityType::class,
				[
					'class'       => Categoria::class,
					'placeholder' => 'Seleccionar Categoría',
					'label'       => 'Categoría'
				] )
			->add( 'fechaNacimientoDesde',
				DateType::class,
				array(
					'widget' => 'single_text',
					'html5'  => true,
					'label'  => 'Fecha de Nacimiento Desde'
				) )
			->add( 'fechaNacimientoHasta',
				DateType::class,
				array(
					'widget' => 'single_text',
					'html5'  => true,
					'label'  => 'Fecha de Nacimiento Desde'
				) )
			->add( 'cantidadRegistros', HiddenType::class )
			->add( 'buscar',
				SubmitType::class,
				array(
					'attr' => array( 'class' => 'btn btn-primary' ),
				) )
			->add( 'limpiar',
				ResetType::class,
				array(
					'attr' => array( 'class' => 'btn btn-default' ),
				) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'csrf_protection' => false,
			'required'        => false
		) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix() {
		return 'app_buscar_jugadores_filter';
	}


}
