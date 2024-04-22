<?php

namespace App\Imports;

use App\Entries;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Carbon\Carbon;

class EntriesImport implements ToModel, WithStartRow, WithCustomCsvSettings
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
        return new Entries([
            'category'  => $row[0],
            'code'  => $row[1],
            'entry_name' => $row[2],
            'age' => $row[4],
            'entry_school' => $row[3],
            'created_at' => Carbon::now(),
        ]);
    }
}
