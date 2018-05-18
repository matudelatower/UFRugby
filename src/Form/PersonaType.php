<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PersonaType extends AbstractType {
	/**
	 * {@inheritdoc}
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'nombre' )
			->add( 'apellido' )
			->add( 'numeroIdentificacion' )
			->add( 'imageFile',
				VichImageType::class,
				[
					'label'        => 'Foto',
					'required'     => false,
					'allow_delete' => true, // optional, default is true
				] )
			->add( 'contacto', ContactoType::class )
			->add( 'fechaNacimiento' )
			->add( 'sexo' )
			->add( 'tipoIdentificacion' )
			->add( 'jugador', JugadorType::class );
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'App\Entity\Persona'
		) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix() {
		return 'App_persona';
	}


}
