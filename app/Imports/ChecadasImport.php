<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ChecadasImport implements ToCollection
{
    public array $resultado = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            echo "<h3>Fila {$index}</h3>";

            echo "<pre>";
            print_r($row->toArray());
            echo "</pre>";

            if ($index >= 20) {
                die();
            }
        }
    }
}