<?php

namespace App\Imports;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class LeadImport implements ToModel
{
   
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        $em1=trim($row[0]);
        $em = collect([$em1]);

        if($em->filter()->isNotEmpty())
        {
            if(isset($row[5]))
            {
                $date = intval($row[5]);
                $da = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
            }
            return new Lead([
                'email'     => $row[1] ?? null,
                'name'    => $row[2] ?? null . ' ' . isset($row[3]),  
                'phone_code' => '61',
                'phone' => $row[4] ?? null,
                'date' => $da ?? null,
                'user_id' => Auth::user()->id,
            ]);
        }
    }
}
