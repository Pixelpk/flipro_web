<?php

namespace App\Imports;

use App\Models\Lead;
use App\Models\LeadSegment;
use App\Models\LeadTag;
use App\Models\Segment;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
class LeadImport implements ToModel, WithStartRow
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
       
       
        if(sizeof($row) == 6)
        {
            $em1=trim($row[0]);
            $em = collect([$em1]);

            if($em->filter()->isNotEmpty())
            {
                if(isset($row[5]))
                {
                    $date = intval($row[3]);
                    $da = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
                }
            
                $lead = Lead::forceCreate([
                    'name'     => $row[0] ?? null,
                    'email'    => $row[1] ?? null . ' ' . isset($row[3]),  
                    'phone_code' => +61,
                    'phone' => str_replace(' ', '', $row[2]) ?? null,
                    'address' => $row[3] ?? null,
                    'date' => $da ?? null,
                    'user_id' => Auth::user()->id,
                ]);
                $segment = explode(',', $row[4]);
                foreach($segment as $item)
                {
                    $newSegment = Segment::where('name', $item)->first();
                    if($newSegment) 
                    {
                        $newSegment = $newSegment;
                    }
                    else
                    {
                        $newSegment = Segment::forceCreate([
                            'name' => $item,
                            'user_id' => Auth::user()->id
                        ]);
                    }
                   
                    LeadSegment::forceCreate([
                        'lead_id' => $lead->id,
                        'segment_id' => $newSegment->id,
                        'user_id' => Auth::user()->id
                    ]);
                }
                ///tag
                $tag = explode(',', $row[5]);
                foreach($tag as $item)
                {
                    $newTag = Tag::where('name', $item)->first();
                    if($newTag) 
                    {
                        $newTag = $newTag;
                    }
                    else
                    {
                        $newTag = Tag::forceCreate([
                            'name' => $item,
                            'user_id' => Auth::user()->id
                        ]);
                    }
                   
                    LeadTag::forceCreate([
                        'lead_id' => $lead->id,
                        'tag_id' => $newTag->id,
                        'user_id' => Auth::user()->id
                    ]);
                }
        }
        }
        
        
    }
}