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

class RolExport implements FromView, ShouldAutoSize
{

    public function view(): View
    {
        return view('exportar.roles', [
            'lstResult' => Roles::all(),
            'empresa' => Empresa::find(2)
        ]);
    }


}
