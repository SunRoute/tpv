<?php

	namespace app\Controllers;

	require_once 'app/Models/Venta.php';
	require_once 'app/Services/ExcelService.php';
	require_once 'app/Services/PdfService.php';

	use app\Models\Venta;
	use app\Services\ExcelService;
	use app\Services\PdfService;


	class VentaController {

		protected $venta;

		public function __construct(){  

			$this->venta = new Venta();
		}

		public function index(){
			return $this->venta->index();
		}

        public function detalle($venta){
			return $this->venta->detalle($venta);
		}
		
		public function pedido($venta){
			return $this->venta->pedido($venta);
		}
		
		public function filtro($fecha,$mesa){
			return $this->venta->filtro($fecha,$mesa);
		}

		public function total($fecha){
			return $this->venta->total($fecha);
		}

		public function cobrar($base, $iva, $precio_total, $pago, $table_id){
 
			$ultimo_ticket = $this->venta->ultimo_ticket();
			$numero_ticket = $this->generarTicket($ultimo_ticket);

			return $this->venta->cobrar($numero_ticket, $base, $iva, $precio_total, $pago, $table_id);
		}

		public function fakeCobrar($base, $iva, $precio_total, $pago, $table_id, $date, $time, $timestamp){
 
			$ultimo_ticket = $this->venta->ultimo_ticket();
			
			$numero_ticket = $this->generarTicket($ultimo_ticket);

			return $this->venta->fakeCobrar($numero_ticket, $base, $iva, $precio_total, $pago, $table_id, $date, $time, $timestamp);
		}

		public function generarTicket($ultimo_ticket){
        
			$fecha = date("ymd");
		
			if(!empty($ultimo_ticket['numero_ticket']) && strpos($ultimo_ticket['numero_ticket'], $fecha) !== false){
				return $ultimo_ticket['numero_ticket'] + 1;
			}else{
				return $fecha."0001";
			}
		}

		public function ocupacion($venta_id, $creacion_ticket){
			return $this->venta->ocupacion($venta_id, $creacion_ticket);
		}

		public function fakeOcupacion($venta_id, $creacion_ticket, $timestamp){
			return $this->venta->fakeOcupacion($venta_id, $creacion_ticket, $timestamp);
		}


		public function getChartData($chart_data){
			return $this->venta->getChartData($chart_data);
		}

		public function exportSaleToExcel($venta_id){

			$excel_service = new ExcelService();
	
			$venta = $this->venta->detalle($venta_id);
			$productos = $this->venta->pedido($venta_id);
			
			$excel_service->exportSaleToExcel($venta, $productos);
		}

		public function exportSalesToExcel(){

			$excel_service = new ExcelService();
	
			$ventas = $this->venta->index();
			
			$excel_service->exportTableToExcel('ventas', $ventas);
		}

		public function exportSaleToPdf($venta_id){

			$ventas = $this->venta->detalle($venta_id);
			$productos = $this->venta->pedido($venta_id);
	
			$html =
				'<html>
					<head>
					<style>
						body {
							margin: 0 auto;
							text-align: center;
							font-family: verdana;
							background-color: lightbue;
						}
					</style>
					</head
					<body>'.
					'<h1>Ticket de venta</h1>'.
					'<p>Número de ticket: '.$ventas['ticket'].'</p>'.
					'<p>Fecha: '.$ventas['ventas.fecha_emision'].'</p>'.
					'<p>Mesa: '.$ventas['mesa'].'</p>'.
	
			$html .= 
				'<table>
					<tr>
						<th>Cantidad</th>
						<th>Descripción</th>
						<th>Total</th>
					</tr>';
	
			foreach($productos as $producto){
				$html .=
				'<tr>
				  <td>'.$producto['cantidad'].'</td>
				  <td>'.$producto['producto'].'</td>
				  <td>'.$producto['base'].'</td>
				</tr>';
			}
	
			$html .=
				'</table>'.
				'<p>Base: '.$ventas['base'].'</p>'.
				'<p>IVA: '.$ventas['iva'].'</p>'.
				'<p>Total: '.$ventas['total'].'</p>'.
				'<p>Forma de pago: '.$ventas['forma_pago'].'</p>';
				'</body></html>';
			
			$pdf_service = new PdfService();
			$pdf = $pdf_service->exportToPdf($html);
	
			file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/pdf/tickets/ticket-'.$ventas['ticket'].'.pdf', $pdf);
		}

    }
?>