<?php

namespace App\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\FormException;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of BootstrapCollectionType
 *
 * @author matias.delatorre at gmail.com
 */
class BootstrapCollectionType extends AbstractType {

	/**
	 * {@inheritdoc}
	 */
	public function buildView( FormView $view, FormInterface $form, array $options ) {

		$view->vars = array_replace( $view->vars,
			array(
				'max_items_add'   => $options['max_items_add'],
				'display_history' => $options['display_history'],
				'extra_actions'   => $options['extra_actions'],
				'prototype_name'  => $options['prototype_name']
			) );
	}


	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {

		$resolver->setDefaults( array(
			'max_items_add'   => 99999,
			'display_history' => true,
			'extra_actions'   => []
		) );
	}

	public function getParent() {
		return CollectionType::class;
	}

	public function getBlockPrefix() {
		return 'bootstrapcollection';
	}

}