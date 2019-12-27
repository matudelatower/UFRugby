<?php

namespace App\Form;

use App\Entity\Club;
use App\Entity\ParticipanteTorneo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class ParticipanteTorneoType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'club',
				EntityType::class,
				[
					'class'         => Club::class,
					'query_builder' => function ( EntityRepository $er ) {
						return $er->createQueryBuilder( 'c' )
						          ->where( 'c.activo = true' );
					},
				] )
		;
	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( [
			'data_class'  => ParticipanteTorneo::class,
			'constraints' => new Valid()
		] );
	}
}
