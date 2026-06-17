<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ChecadasImport implements ToCollection
{
    public function collection(Collection $rows)
{
    foreach ($rows as $index => $row) {

        echo "<pre>";
        echo "Fila: " . $index . "\n";
        print_r($row->toArray());
        echo "</pre>";

        if ($index >= 20) {
            die();
        }
    }
}
}