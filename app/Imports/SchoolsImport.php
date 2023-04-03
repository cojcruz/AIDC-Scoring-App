<?php

namespace App\Imports;

use App\School;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Carbon\Carbon;


class SchoolsImport implements ToModel, WithStartRow, WithCustomCsvSettings
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
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        return new School([
            'school_name'  => $row[0],
            'created_at' => Carbon::now(),
        ]);
    }
}
