<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 28/6/18
 * Time: 18:29
 */

namespace App\Service;


use Knp\Snappy\Pdf;

class ReporteManager {

	private $twig;
	private $pdf;

	public function __construct( \Twig_Environment $twig, Pdf $pdf ) {
		$this->twig = $twig;
		$this->pdf  = $pdf;
	}

	public function imprimir( $html, $orientation = "V", $margin = null, $pageSize = 'A4' ) {
		$orientation = ( $orientation == 'V' ) ? 'Portrait' : 'Landscape';
		if ( $margin == null ) {
			$margin = array(
				'right'  => '1cm',
				'bottom' => '1cm',
			);
			if ( $orientation == 'portrait' ) {
				$margin['top']  = '2cm';
				$margin['left'] = '2cm';
			} else {
				$margin['top']  = '4cm';
				$margin['left'] = '1cm';
			}
		}

		$header = $this->twig->render( 'reportes/encabezado.pdf.twig' );
		$footer = $this->twig->render( 'reportes/pie_de_pagina.pdf.twig' );

		return $this->pdf->getOutputFromHtml( $html,
			array(
				'margin-left'    => $margin['left'],
				'margin-right'   => $margin['right'],
				'margin-top'     => $margin['top'],
				'margin-bottom'  => $margin['bottom'],
				'footer-html'    => $footer,
				'header-html'    => $header,
				'header-spacing' => '5',
				'page-size'      => $pageSize,
				'orientation'    => "$orientation",
			) );
	}
}