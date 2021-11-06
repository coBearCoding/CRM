<?php

namespace App\Imports;

use App\ContactoGeneral;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MailingImport implements ToModel,WithHeadingRow
{
    public function model(array $row)
    {
        return new ContactoGeneral([
            'email' => $row['email'],
            'nombres' => $row['nombres']
        ]);
    }
}
