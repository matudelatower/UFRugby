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

			$keyAdministracion = 'ADMINISTRACIÓN';
			$menu->addChild(
				$keyAdministracion,
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

				$menu[ $keyAdministracion ]
					->addChild(
						'Parámetros',
						array(
							'route' => 'admin',
						)
					);

			}

			if ( $this->authorizationChecker->isGranted( 'ROLE_ADMIN' ) ||
			     $this->authorizationChecker->isGranted( 'ROLE_UNION' ) ) {

				$menu[ $keyAdministracion ]
					->addChild(
						'Clubs',
						array(
							'route' => 'club_index',
						)
					);

				$menu[ $keyAdministracion ]
					->addChild(
						'Registro de Pagos',
						array(
							'route' => 'pagoclub_index',
						)
					);

				$menu[ $keyAdministracion ]
					->addChild(
						'Pases',
						array(
							'route' => 'pase_index',
						)
					);

			}

			if ( $this->authorizationChecker->isGranted( 'ROLE_CLUB' ) ) {
				$menu[ $keyAdministracion ]
					->addChild(
						'Registro de Pagos',
						array(
							'route' => 'pagojugador_index',
						)
					);

				$menu[ $keyAdministracion ]
					->addChild(
						'Buscar Jugadores',
						array(
							'route' => 'buscar_jugador',
						)
					);


				$menu->addChild(
					'Pases',
					array(
						'childrenAttributes' => array(
							'class' => 'treeview-menu',
						),
					)
				)
				     ->setUri( '#' )
				     ->setExtra( 'icon', 'fa fa-exchange' )
				     ->setAttribute( 'class', 'treeview' );

				$menu['Pases']
					->addChild(
						'Solicitudes Enviadas',
						array(
							'route' => 'pase_solicitudes_enviadas',
						)
					);

				$menu['Pases']
					->addChild(
						'Solicitudes Recibidas',
						array(
							'route' => 'pase_solicitudes_recibidas',
						)
					);
			}

			if ( $this->authorizationChecker->isGranted( 'ROLE_CLUB' ) ||
			     $this->authorizationChecker->isGranted( 'ROLE_UNION' ) ) {

				$menu[ $keyAdministracion ]
					->addChild(
						'Registro de Jugadores',
						array(
							'route' => 'clubjugador_index',
						)
					);
			}
			if ( $this->authorizationChecker->isGranted( 'ROLE_ADMIN' ) ||
				 $this->authorizationChecker->isGranted( 'ROLE_CLUB' ) ||
			     $this->authorizationChecker->isGranted( 'ROLE_UNION' ) ) {
			$menu[ $keyAdministracion ]
				->addChild(
					'Jugadores',
					array(
						'route' => 'jugador_index',
					)
				);
		}
		}

		if ( $this->authorizationChecker->isGranted( 'ROLE_ADMIN' ) ||
		     $this->authorizationChecker->isGranted( 'ROLE_UNION' ) ||
		     $this->authorizationChecker->isGranted( 'ROLE_REFEREE_ADMIN' ) ) {

			$menu[ $keyAdministracion ]
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