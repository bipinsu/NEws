<?php

namespace App\Exports;

use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PermissionExport implements FromQuery,WithMapping,WithHeadings
{
    use Exportable;

    protected $selectedRows;

    public function __construct($selectedRows)
    {
        $this->selectedRows=$selectedRows;
        
    }
    public function map($permission):array
    {
        
        return[
            $permission->id,
            $permission->name,
            $permission->group_name,
            
        ];
    }
    public function headings():array {
        return[
            'Id',
            'Title',
            'Group Name',
        ];
    }
    public function query()
    {
        return Permission::whereIn('id',$this->selectedRows);
    }
}
