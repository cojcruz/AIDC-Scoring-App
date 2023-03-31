<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class EntriesImport implements ToCollection
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
            'code'  => $row[0],
            'entry_school'  => $row[1],
            'entry_name' => $row[2],
            'category' => $row[3],
            'created_at' => Carbon::now(),
        ]);
    }
}
