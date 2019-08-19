<?php

namespace App\Exports;

use App\Entries;
use Maatwebsite\Excel\Concerns\FromCollection;

class EntriesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Entries::all();
    }
}
