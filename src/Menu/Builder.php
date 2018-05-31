<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class Builder {

	private $factory;
	private $authorizationChecker;

	/**
	 * @param FactoryInterface $factory
	 *
	 * Add any other dependency you need
	 */
	public function __construct( FactoryInterface $factory, AuthorizationCheckerInterface $authorizationChecker ) {
		$this->factory              = $factory;
		$this->authorizationChecker = $authorizationChecker;
	}

	public function mainMenu( array $options ) {
//		$menu = $factory->createItem('root');
//
//		$menu->addChild('Home', array('route' => 'app_homepage'));

		$menu = $this->factory->createItem(
			'root',
			array(
				'childrenAttributes' => array(
					'class'       => 'sidebar-menu tree',
					'data-widget' => 'tree'
				),
			)
		);

		$menu->addChild(
			'MENU PRINCIPAL'
		)->setAttribute( 'class', 'header' );

		if ( $this->authorizationChecker->isGranted( 'ROLE_USER' ) ) {

			$keyPersonal = 'ADMINISTRACIÓN';
			$menu->addChild(
				$keyPersonal,
				array(
					'childrenAttributes' => array(
						'class' => 'treeview-menu',
					),
				)
			)
			     ->setUri( '#' )
			     ->setExtra( 'icon', 'fa fa-folder-open-o' )
			     ->setAttribute( 'class', 'treeview' );

			if ( $this->authorizationChecker->isGranted( 'ROLE_ADMIN' ) ) {

				$menu[ $keyPersonal ]
					->addChild(
						'Parámetros',
						array(
							'route' => 'admin',
						)
					);

			}

			if ( $this->authorizationChecker->isGranted( 'ROLE_ADMIN' ) ||
			     $this->authorizationChecker->isGranted( 'ROLE_UNION' ) ) {

				$menu[ $keyPersonal ]
					->addChild(
						'Clubs',
						array(
							'route' => 'club_index',
						)
					);

				$menu[ $keyPersonal ]
					->addChild(
						'Registro de Pagos',
						array(
							'route' => 'pagoclub_index',
						)
					);

			}

			if ( $this->authorizationChecker->isGranted( 'ROLE_CLUB' ) ) {
				$menu[ $keyPersonal ]
					->addChild(
						'Registro de Pagos',
						array(
							'route' => 'pagojugador_index',
						)
					);
			}

			$menu[ $keyPersonal ]
				->addChild(
					'Registro de Jugadores',
					array(
						'route' => 'clubjugador_index',
					)
				);

			$menu[ $keyPersonal ]
				->addChild(
					'Pases',
					array(
//						'route' => 'jugador_index',
						'uri' => '#',
					)
				);

			$menu[ $keyPersonal ]
				->addChild(
					'Jugadores',
					array(
						'route' => 'jugador_index',
					)
				);

//			$menu[ $keyPersonal ]
//				->addChild(
//					'Personas',
//					array(
//						'route' => 'persona_index',
//					)
//				);
		}

		if ( $this->authorizationChecker->isGranted( 'ROLE_ADMIN' ) ||
		     $this->authorizationChecker->isGranted( 'ROLE_UNION' ) ) {

			$menu[ $keyPersonal ]
				->addChild(
					'Referees',
					array(
						'route' => 'referee_index',
					)
				);

		}


		return $menu;
	}
}