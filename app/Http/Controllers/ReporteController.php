<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Exports\RolExport;
use App\Roles;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{

    public function exportRol()
    {
        try {
            return Excel::download(new RolExport(), 'rpt_roles.xlsx');
        } catch (\Exception $e) {
            dd('Ha ocurrido un error', $e->getMessage());
        }

    }

    public function imprimirRol()
    {
        try {
            $lstResult = Roles::all();
            $empresa = Empresa::find(2);

            $pdf = \PDF::loadView('exportar.roles', compact('lstResult','empresa'));
            return $pdf->download('rpt_roles.pdf');
        } catch (\Exception $e) {
            dd('Ha ocurrido un error', $e->getMessage());
        }
    }

}
