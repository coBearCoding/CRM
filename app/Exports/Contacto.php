<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class Contacto implements FromView, ShouldAutoSize
{
    protected $datos;
   	protected $empresa;
  // 	protected $estados;

    public function __construct($datos,$empresa)
    {
        $this->datos = $datos;
        $this->empresa = $empresa;
       // $this->estados = $estados;
    }

    public function view(): View
    {
        return view('exportar.contacto', [
            'datos' => $this->datos,
            'empresa' => $this->empresa
        ]);
    }
}
