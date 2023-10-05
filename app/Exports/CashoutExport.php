<?php

namespace App\Exports;

use App\Models\Cashout;
use Maatwebsite\Excel\Concerns\FromCollection;

class CashoutExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cashout::all();
    }
}
