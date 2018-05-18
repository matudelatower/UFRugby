<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrecompetitivoType extends AbstractType {
	/**
	 * {@inheritdoc}
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'nombre' )
			->add( 'apellido' )
			->add( 'numeroIdentificacion',
				TextType::class,
				[
					'label' => 'Nº identificación'
				] )
			->add( 'contacto', ContactoType::class )
			->add( 'fechaNacimiento',
				DateType::class,
				array(
					'widget' => 'single_text',
					'format' => 'dd/MM/yyyy',
					'attr'   => array(
						'class' => 'datepicker',
					),
				) )
			->add( 'sexo',
				EntityType::class,
				[
					'required'    => true,
					'class'       => 'App\Entity\Sexo',
					'placeholder' => 'Seleccionar',
					'label'       => 'Sexo *'
				] )
			->add( 'tipoIdentificacion',
				EntityType::class,
				[
					'required'    => true,
					'class'       => 'App\Entity\TipoIdentificacion',
					'placeholder' => 'Seleccionar',
					'label'       => 'Tipo de Identificación *'
				] )
			->add( 'jugador', JugadorType::class );
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'App\Entity\Persona',
		) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix() {
		return 'App_precompetitivo';
	}


}
