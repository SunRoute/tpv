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

    public function exportTableToExcel($table, $elements)
    {

        $spreedsheet = IOFactory::load($_SERVER["DOCUMENT_ROOT"] .'/excel/templates/table.xls');
        $spreedsheet->setActiveSheetIndex(0);

        $letter = 'A';

        foreach($elements[0] as $key => $value){
            $spreedsheet->getActiveSheet()->setCellValue(strtoupper($letter) . '1', $key);
            ++$letter;
        }

        for($i = 0; $i < count($elements); $i++){
           
            $spreedsheet->getActiveSheet()->insertNewRowBefore(2 + $i, 1);
            $letter = 'A';

            foreach ($elements[$i] as $key => $value) {
                $spreedsheet->getActiveSheet()->setCellValue($letter . ($i + 2), $elements[$i][$key]);
                ++$letter;
            }
        }

        $writer = new Xlsx($spreedsheet);        
        $excel_file = $writer->save($_SERVER["DOCUMENT_ROOT"] . '/excel/tables/table-'.$table.'.xls');
    }

    public function exportExcelToPdf($excel_file, $filename)
    {
        $pdf = new Dompdf($excel_file);
        $pdf_file = $pdf->save($filename.".pdf");

        return $pdf_file;
    }
}

?>