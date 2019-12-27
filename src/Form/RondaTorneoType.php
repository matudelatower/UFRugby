<?php

namespace App\Form;

use App\Entity\RondaTorneo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RondaTorneoType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'nombre' )
			->add( 'puntosGanado',
				IntegerType::class,
				[
					'label' => 'Ganado',
					'data'  => 4
				] )
			->add( 'puntosPerdido',
				IntegerType::class,
				[
					'label' => 'Perdido',
					'data'  => 0
				] )
			->add( 'puntosEmpatado',
				IntegerType::class,
				[
					'label' => 'Empatado',
					'data'  => 2
				] )
			->add( 'puntosPorWalkover',
				IntegerType::class,
				[
					'label' => 'Puntos Por WalkOver',
					'data'  => 4
				] )
			->add( 'tantosPorWalkover',
				IntegerType::class,
				[
					'label' => 'Tantos Por WalkOver',
					'data'  => 21
				] )
			->add( 'bonusTriunfoCantidadTriesMayorA',
				IntegerType::class,
				[
					'label' => 'Triunfo por cantidad de tries mayor a',
					'data'  => 4
				] )
			->add( 'bonusTriunfoDiferenciaTriesMayorA',
				IntegerType::class,
				[
					'label' => 'Triunfo por diferencia de tries mayor a',
					'data'  => 3
				] )
			->add( 'bonusDerrotaDiferenciaPuntos',
				IntegerType::class,
				[
					'label' => 'Derrota por diferencia de puntos menor a',
					'data'  => 7
				] )
			->add( 'activo' );
	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( [
			'data_class' => RondaTorneo::class,
		] );
	}
}
