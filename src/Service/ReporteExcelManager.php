<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 28/6/18
 * Time: 18:29
 */

namespace App\Service;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;


class ReporteExcelManager {

//	private $phpexcel;
	private $container;

	public function __construct( ContainerBagInterface $container) {
//		$this->phpexcel = $phpexcel;
		$this->container = $container;
	}

	public function exportarExcel( $title, $data, $titleSheet = 'Hoja 1' ) {

//		$phpExcelObject = $this->phpexcel->createPHPExcelObject();
//		$phpExcelObject = $this->phpexcel;
		$phpExcelObject = new Spreadsheet();


		$phpExcelObject->getProperties()->setCreator( $this->container->get('app.site_name') )
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
//		$writer = $this->phpexcel->createWriter( $phpExcelObject, 'Xlsx' );

		$writer = new Xlsx($phpExcelObject);

		return $writer;
//		$writer->save();
//
//		return $this->phpexcel->createStreamedResponse( $writer );

	}
}