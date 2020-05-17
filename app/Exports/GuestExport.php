<?php

namespace App\Exports;

use App\Guest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GuestExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Guest::select(
                        'id'
                        ,'last_name'
                        ,'first_name'
                        ,'gender'
                        ,'birth_date'
                        ,'citizenship'
                        ,'document_type'
                        ,'document'
                        ,'address'
                        ,'arrival_date'
                        ,'est_departure_date'
                        ,'act_departure_date'
                        ,'created_at'
                        ,'updated_at'
                        )->get();
    }

    public function headings(): array
    {
        return [
            'id'
            ,'last_name'
            ,'first_name'
            ,'gender'
            ,'birth_date'
            ,'citizenship'
            ,'document_type'
            ,'document'
            ,'address'
            ,'arrival_date'
            ,'est_departure_date'
            ,'act_departure_date'
            ,'created_at'
            ,'updated_at'
        ];
    }
}
