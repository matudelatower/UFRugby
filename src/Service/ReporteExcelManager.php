<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 28/6/18
 * Time: 18:29
 */

namespace App\Service;

use Onurb\Bundle\ExcelBundle\Factory\CompatibilityFactory;

class ReporteExcelManager {

	private $phpexcel;

	public function __construct( CompatibilityFactory $phpexcel ) {
		$this->phpexcel = $phpexcel;
	}


	public function exportarExcel( $title, $data, $titleSheet = 'Hoja 1' ) {

		$phpExcelObject = $this->phpexcel->createPHPExcelObject();

		$phpExcelObject->getProperties()->setCreator( "URP" )
//		               ->setLastModifiedBy("Giulio De Donato")
                       ->setTitle( $title )
//		               ->setSubject("Office 2005 XLSX Test Document")
//		               ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
//		               ->setKeywords("office 2005 openxml php")
//		               ->setCategory("Test result file")
		;

		foreach ( $data as $key => $datum ) {
			$phpExcelObject->setActiveSheetIndex( 0 )
			               ->setCellValue( $key, $datum );
		}


		foreach ( range( 'A', 'Z' ) as $letra ) {
			$phpExcelObject->getActiveSheet()->getColumnDimension( $letra )->setAutoSize( 'true' );
		}

		$phpExcelObject->getActiveSheet()->setTitle( $titleSheet );
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$phpExcelObject->setActiveSheetIndex( 0 );

		// create the writer
		$writer = $this->phpexcel->createWriter( $phpExcelObject, 'Xlsx' );

		return $this->phpexcel->createStreamedResponse( $writer );

	}
}