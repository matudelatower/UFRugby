<?php

namespace App\Form;

use App\Entity\Persona;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
			->add( 'tipoIdentificacion' )
			->add( 'numeroIdentificacion' )
			->add( 'imageFile',
				VichImageType::class,
				[
					'label'        => 'Foto',
					'required'     => false,
					'allow_delete' => true, // optional, default is true
				] )
			->add( 'contacto', ContactoType::class )
			->add( 'fechaNacimiento',
				DateType::class,
				array(
					'widget' => 'single_text',
					'html5'  => true
				) )
			->add( 'sexo' )
			//			->add( 'jugador', JugadorType::class )
		;
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => Persona::class
		) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix() {
		return 'App_persona';
	}


}
