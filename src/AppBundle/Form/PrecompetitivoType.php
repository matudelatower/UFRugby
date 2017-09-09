<?php

namespace AppBundle\Form;

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
			->add( 'sexo' )
			->add( 'tipoIdentificacion',
				EntityType::class,
				[
					'label' => 'Tipo identificación',
					'class' => 'AppBundle\Entity\TipoIdentificacion'
				] )
			->add( 'jugador', JugadorType::class );
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'AppBundle\Entity\Persona',
			'required'   => false, //TODO descomentar cuando salga de muestra
		) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix() {
		return 'appbundle_precompetitivo';
	}


}
