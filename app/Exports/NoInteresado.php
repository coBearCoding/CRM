<?php

namespace App\Exports;

use App\Empresa;
use App\Roles;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class NoInteresado implements FromView, ShouldAutoSize
{
   	protected $datos;
   	protected $empresa;
   	protected $estados;
   	protected $fecha_inicio;
   	protected $fecha_fin;

    public function __construct($datos,$empresa,$estados,$fecha_inicio,$fecha_fin)
    {
        $this->datos = $datos;
        $this->empresa = $empresa;
        $this->estados = $estados;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    public function view(): View
    {
        return view('exportar.NoInteresado_xls', [
            'datos' => $this->datos,
            'empresa' => $this->empresa,
            'estados' => $this->estados,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin
        ]);
    }
}
