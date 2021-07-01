<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'username',
				TextType::class,
				[
					'label' => 'Nombre de usuario'
				] )
			->add( 'email' )
			->add( 'enabled',
				CheckboxType::class,
				[
					'label' => 'Activo'
				] )
			->add( 'plainPassword',
				TextType::class,
				[
					'label'    => 'Password en plano',
					'required' => false,
					'mapped'   => false
				] )
			->add( 'roles',
				ChoiceType::class,
				[
					'multiple' => true,
					'choices'  => [
						'ROLE_USER'          => 'ROLE_USER',
						'ROLE_CLUB'          => 'ROLE_CLUB',
						'ROLE_REFEREE'       => 'ROLE_REFEREE',
						'ROLE_REFEREE_ADMIN' => 'ROLE_REFEREE_ADMIN',
						'ROLE_UNION'         => 'ROLE_UNION'
					]
				] )
//            ->add('persona')
			->add( 'club',
				EntityType::class,
				[
					'class'       => 'App\Entity\Club',
					'required'    => false,
					'placeholder' => 'Seleccionar Club',
					'label'       => 'Club *',
					'attr'        => [ 'class' => 'select2' ]
				] );
	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( [
			'data_class' => Usuario::class,
		] );
	}
}
