<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;

use Maatwebsite\Excel\Concerns\WithHeadings;

class PlantillaLeads implements Responsable,  WithHeadings
{
    use Exportable;
 
    //previous code
 
    /**
     * @param mixed $row
     *
     * @return array
     */
     public function headings(): array
    {
        return [
            'Full name',
            'E-mail',
            'Enabled'
        ];
    }
}
