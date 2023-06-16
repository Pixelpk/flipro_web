<?php

namespace App\Exports;

use App\Models\Project;
use App\Models\ProjectAccess;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class ProjectExport implements FromCollection, WithMapping, WithHeadings,ShouldAutoSize
{
    protected $projectId;

    public function __construct(array $projectId)
    {
       
        $this->projectId = $projectId;
    }

    public function collection()
    {
        return Project::whereIn('id', $this->projectId)->get();
    }

    public function map($project): array
    {
      
        $role = [];
        foreach($project->toArray() as $item) 
        {
            $getData = ProjectAccess::where('project_id', $item)->get();
            foreach($getData as $data) 
            {
                $concat = $data->user->name.' '. '('.$data->acting_as.')';
                array_push($role,$concat);
            }
            break;
        }
        $implode = implode(',', $role);
        $photos = implode(',', $project->photos);
        return [
            date('d-m-Y', strtotime($project->created_at)),
            ucfirst($project->status),
            $project->applicant_name,
            $project->email,
           
            $project->phone_code . ' ' . substr($project->phone, 0, 3) . " " . substr($project->phone, 3, 3) . " " . substr($project->phone, 6),
            $project->registered_owners,
            '$'.number_format((float) $project->current_property_value),
            '$'.number_format((float) $project->property_debt),
            $project->cross_collaterized == 1 ? "YES" : "NO",
            $project->title,
            number_format((float) $project->area),
            '$'.number_format((float) $project->anticipated_budget),
            $project->applicant_address,
            $project->project_state,
            $project->contractor_supplier_details == 1 ? "YES" : "NO",
            $project->description,
            // $implode,
            $this->formatColumnValue($photos),
            $this->formatColumnRole($implode),
           
            // Add more columns as needed
        ];
    }

    public function headings(): array
    {
        return [
            'Created date',
            'Project Status',
            'Applicant Name',
            'Applicant Email',
            'Applicant Phone',
            'Register Owner',
            'Current Value',
            'Property Debts',
            'Cross Collaterized',
            'Project Address',
            'Area (Square Metre)',
            'Anticipated Budget',
            'Applicant Address',
            'Suburb, State and postal code',
            'Existing Queries',
            'Description',
            'Photos',
            'Role',
           
            // Add more headings as needed
        ];
    }

    private function formatColumnValue($value)
    {
        // Perform any formatting or line break insertion here
        return str_replace(',', "\n", $value);
    }
    private function formatColumnRole($value)
    {
        // Perform any formatting or line break insertion here
        return str_replace(',', "\n", $value);
    }
}
