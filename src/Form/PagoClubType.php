<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagoClubType extends AbstractType {
	/**
	 * {@inheritdoc}
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'fecha',
			DateType::class,
			array(
				'widget' => 'single_text',
				'format' => 'dd/MM/yyyy',
				'attr'   => array(
					'class' => 'datepicker',
				),
			) )
		        ->add( 'monto' )
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
			        ] )
		        ->add( 'club',
			        EntityType::class,
			        [
				        'class'       => 'App\Entity\Club',
				        'required'    => true,
				        'placeholder' => 'Seleccionar Club',
				        'label'       => 'Club *',
				        'attr'        => [ 'class' => 'select2' ]
			        ] );
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'App\Entity\PagoClub'
		) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix() {
		return 'App_pagoclub';
	}


}
