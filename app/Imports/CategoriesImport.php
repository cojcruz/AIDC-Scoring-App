<?php

namespace App\Imports;

use App\Categories;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Carbon\Carbon;

class CategoriesImport implements ToModel, WithStartRow, WithCustomCsvSettings
{

    public function startRow(): int {
        return 2;
    }

    public function getCsvSettings(): array {
        return [
            'delimiter' => ','
        ];
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Categories([
            'name'  => $row[0],
            'code'  => $row[1],
            'created_at' => Carbon::now(),
        ]);
    }
}
