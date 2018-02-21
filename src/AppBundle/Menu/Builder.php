<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface {
	use ContainerAwareTrait;

	public function mainMenu( FactoryInterface $factory, array $options ) {
//		$menu = $factory->createItem('root');
//
//		$menu->addChild('Home', array('route' => 'app_homepage'));

		$menu = $factory->createItem(
			'root',
			array(
				'childrenAttributes' => array(
					'class' => 'sidebar-menu',
				),
			)
		);

		$menu->addChild(
			'MENU PRINCIPAL'
		)->setAttribute( 'class', 'header' );

		if ( $this->container->get( 'security.authorization_checker' )->isGranted( 'ROLE_MESA_ENTRADA' ) ) {

			$keyEmpresa = 'MESA ENTRADA';
			$menu->addChild(
				$keyEmpresa,
				array(
					'childrenAttributes' => array(
						'class' => 'treeview-menu',
					),
				)
			)
			     ->setUri( '#' )
			     ->setExtra( 'icon', 'fa fa-exchange' )
			     ->setAttribute( 'class', 'treeview' );

			$menu[ $keyEmpresa ]
				->addChild(
					'Expedientes',
					array(
						'route' => 'expediente_index',
					)
				);
		}
		if ( $this->container->get( 'security.authorization_checker' )->isGranted( 'ROLE_PERSONAL' ) ) {

			$keyPersonal = 'PERSONAL';
			$menu->addChild(
				$keyPersonal,
				array(
					'childrenAttributes' => array(
						'class' => 'treeview-menu',
					),
				)
			)
			     ->setUri( '#' )
			     ->setExtra( 'icon', 'fa fa-users' )
			     ->setAttribute( 'class', 'treeview' );
			$menu[ $keyPersonal ]
				->addChild(
					'Personas',
					array(
						'route' => 'persona_index',
					)
				);
		}

		if ( $this->container->get( 'security.authorization_checker' )->isGranted( 'ROLE_USER' ) ) {

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

			if ( $this->container->get( 'security.authorization_checker' )->isGranted( 'ROLE_ADMIN' ) ) {

				$menu[ $keyPersonal ]
					->addChild(
						'Parámetros',
						array(
							'route' => 'admin',
						)
					);

				$menu[ $keyPersonal ]
					->addChild(
						'Clubs',
						array(
							'route' => 'club_index',
						)
					);
			}
			if ( $this->container->get( 'security.authorization_checker' )->isGranted( 'ROLE_UNION' ) ) {
				$menu[ $keyPersonal ]
					->addChild(
						'Registro de Pagos',
						array(
							'route' => 'pagoclub_index',
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


		return $menu;
	}
}