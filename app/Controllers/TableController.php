<?php

namespace app\Controllers;

class TableController {

    protected $saludo;

	public function __construct(){  

		$this->saludo = "hola";
	}

	public function index(){

        $mesas = [
            "1" => [
                "numero" => "1",
                "estado" => "1"
            ],
            "2" => [
                "numero" => "2",
                "estado" => "0"
            ],
            "3" => [
                "numero" => "3",
                "estado" => "1"
            ],
            "4" => [
                "numero" => "4",
                "estado" => "1"
            ],
            "5" => [
                "numero" => "5",
                "estado" => "0"
            ],
            "6" => [
                "numero" => "6",
                "estado" => "1"
            ],
            "7" => [
                "numero" => "7",
                "estado" => "1"
            ],
            "8" => [
                "numero" => "8",
                "estado" => "0"
            ],
            "9" => [
                "numero" => "9",
                "estado" => "1"
            ]
        ];

        return $mesas;
	}
}
