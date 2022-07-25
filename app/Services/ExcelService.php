<?php

namespace app\Services;

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;

class ExcelService {

	public function exportSaleToExcel($venta, $productos)
    {

        $spreedsheet = IOFactory::load($_SERVER["DOCUMENT_ROOT"] .'/excel/templates/ticket.xls');
        $spreedsheet->setActiveSheetIndex(0);

        $spreedsheet->getActiveSheet()->setCellValue('A3', $venta['ticket']);
        $spreedsheet->getActiveSheet()->setCellValue('D2', $venta['fecha_emision']);
        $spreedsheet->getActiveSheet()->setCellValue('D3', $venta['hora_emision']);
        $spreedsheet->getActiveSheet()->setCellValue('D6', $venta['base']);
        $spreedsheet->getActiveSheet()->setCellValue('D8', $venta['iva']);
        $spreedsheet->getActiveSheet()->setCellValue('D9', $venta['total']);

        for($i = 0; $i < count($productos); $i++){
            $spreedsheet->getActiveSheet()->insertNewRowBefore(6 + $i, 1); 
            $spreedsheet->getActiveSheet()->setCellValue('A' . ($i + 6), $productos[$i]['producto']);
            $spreedsheet->getActiveSheet()->setCellValue('B' . ($i + 6), $productos[$i]['cantidad']);
            $spreedsheet->getActiveSheet()->setCellValue('C' . ($i + 6), $productos[$i]['base']);
            $spreedsheet->getActiveSheet()->setCellValue('D' . ($i + 6), '=B'.($i + 6).'*C'.($i + 6));
        }

        $writer = new Xlsx($spreedsheet);        
        $excel_file = $writer->save($_SERVER["DOCUMENT_ROOT"] . '/excel/tickets/ticket-'.$venta['ticket'].'.xls');

        return $excel_file;
	}

    public function exportProductToExcel($productos)
    {

        $spreedsheet = IOFactory::load($_SERVER["DOCUMENT_ROOT"] .'/excel/templates/listado-productos.xls');
        $spreedsheet->setActiveSheetIndex(0);

        for($i = 0; $i < count($productos); $i++){
            $spreedsheet->getActiveSheet()->insertNewRowBefore(2 + $i, 1); 
            $spreedsheet->getActiveSheet()->setCellValue('A' . ($i + 2), $productos[$i]['nombre']);
            $spreedsheet->getActiveSheet()->setCellValue('B' . ($i + 2), $productos[$i]['categoria']);
            $spreedsheet->getActiveSheet()->setCellValue('C' . ($i + 2), $productos[$i]['iva']);
            $spreedsheet->getActiveSheet()->setCellValue('D' . ($i + 2), $productos[$i]['base']);
        }

        $writer = new Xlsx($spreedsheet);        
        $excel_file = $writer->save($_SERVER["DOCUMENT_ROOT"] . '/excel/productos/productos.xls');

        return $excel_file;
	}

    public function exportExcelToPdf($excel_file, $filename)
    {
        $pdf = new Dompdf($excel_file);
        $pdf_file = $pdf->save($filename.".pdf");

        return $pdf_file;
    }
}

?>