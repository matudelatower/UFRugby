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


		$menu = $this->factory->createItem(
			'root',
			[
				'childrenAttributes' => [
					'class'          => 'nav nav-pills nav-sidebar flex-column',
					'data-widget'    => 'treeview',
					'data-accordion' => 'false',
					'role'           => 'menu'
				],
			]
		);

		$menu->addChild(
			'MENU PRINCIPAL'
		)->setAttribute( 'class', 'nav-header' );

		if ( $this->authorizationChecker->isGranted( 'ROLE_USER' ) ) {

			$keyAdministracion = 'ADMINISTRACIÓN';
			$menu->addChild(
				$keyAdministracion,
				[
					'childrenAttributes' =>
						[ 'class' => 'nav nav-treeview', ],
				]
			)
			     ->setUri( '#' )
			     ->setLinkAttribute( 'class', 'nav-link' )
			     ->setExtra( 'icon', 'fas fa-folder' )
			     ->setAttribute( 'class', 'nav-item has-treeview' );

			if ( $this->authorizationChecker->isGranted( 'ROLE_ADMIN' ) ) {

				$menu[ $keyAdministracion ]
					->addChild(
						'Parámetros',
						array(
							'route'          => 'easyadmin',
							'attributes'     => [ 'class' => 'nav-item' ],
							'linkAttributes' => [ 'class' => 'nav-link' ]
						)
					);

			}

			if ( $this->authorizationChecker->isGranted( 'ROLE_ADMIN' ) ||
			     $this->authorizationChecker->isGranted( 'ROLE_UNION' ) ) {

				$menu[ $keyAdministracion ]
					->addChild(
						'Clubes',
						array(
							'route'          => 'club_index',
							'attributes'     => [ 'class' => 'nav-item' ],
							'linkAttributes' => [ 'class' => 'nav-link' ]
						)
					);

				$menu[ $keyAdministracion ]
					->addChild(
						'Registro de Pagos',
						array(
							'route'          => 'pagoclub_index',
							'attributes'     => [ 'class' => 'nav-item' ],
							'linkAttributes' => [ 'class' => 'nav-link' ]
						)
					);

				$menu[ $keyAdministracion ]
					->addChild(
						'Pases',
						array(
							'route'          => 'pase_index',
							'attributes'     => [ 'class' => 'nav-item' ],
							'linkAttributes' => [ 'class' => 'nav-link' ]
						)
					);

			}

			if ( $this->authorizationChecker->isGranted( 'ROLE_CLUB' ) ) {
				$menu[ $keyAdministracion ]
					->addChild(
						'Registro de Pagos',
						array(
							'route'          => 'pagojugador_index',
							'attributes'     => [ 'class' => 'nav-item' ],
							'linkAttributes' => [ 'class' => 'nav-link' ]
						)
					);

				$menu[ $keyAdministracion ]
					->addChild(
						'Buscar Jugadores',
						array(
							'route'          => 'buscar_jugador',
							'attributes'     => [ 'class' => 'nav-item' ],
							'linkAttributes' => [ 'class' => 'nav-link' ]
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
				     ->setLinkAttribute( 'class', 'nav-link' )
				     ->setExtra( 'icon', 'fas fa-exchange' )
				     ->setAttribute( 'class', 'nav-item has-treeview' );


				$menu['Pases']
					->addChild(
						'Solicitudes Enviadas',
						array(
							'route'          => 'pase_solicitudes_enviadas',
							'attributes'     => [ 'class' => 'nav-item' ],
							'linkAttributes' => [ 'class' => 'nav-link' ]
						)
					);

				$menu['Pases']
					->addChild(
						'Solicitudes Recibidas',
						array(
							'route'          => 'pase_solicitudes_recibidas',
							'attributes'     => [ 'class' => 'nav-item' ],
							'linkAttributes' => [ 'class' => 'nav-link' ]
						)
					);
			}

			if ( $this->authorizationChecker->isGranted( 'ROLE_CLUB' ) ||
			     $this->authorizationChecker->isGranted( 'ROLE_UNION' ) ) {

				$menu[ $keyAdministracion ]
					->addChild(
						'Registro de Jugadores',
						array(
							'route'          => 'clubjugador_index',
							'attributes'     => [ 'class' => 'nav-item' ],
							'linkAttributes' => [ 'class' => 'nav-link' ]
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
							'route'          => 'jugador_index',
							'attributes'     => [ 'class' => 'nav-item' ],
							'linkAttributes' => [ 'class' => 'nav-link' ]
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
						'route'          => 'referee_index',
						'attributes'     => [ 'class' => 'nav-item' ],
						'linkAttributes' => [ 'class' => 'nav-link' ]
					)
				);
		}

		if ( $this->authorizationChecker->isGranted( 'ROLE_UNION' ) ) {

			$menu[ $keyAdministracion ]
				->addChild(
					'Usuarios',
					array(
						'route'          => 'usuario_index',
						'attributes'     => [ 'class' => 'nav-item' ],
						'linkAttributes' => [ 'class' => 'nav-link' ]
					)
				);
		}


		return $menu;
	}
}