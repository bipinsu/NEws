<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RoleExport implements FromQuery,WithMapping,WithHeadings
{
    use Exportable;

    protected $selectedRows;

    public function __construct($selectedRows)
    {
        $this->selectedRows=$selectedRows;
        
    }
    public function map($role):array
    {
        $permissions = $role->permissions->pluck('name')->implode(', ');
        return[
            $role->id,
            $role->name,
            $permissions, 
        ];
    }
    public function headings():array {
        return[
            'Id',
            'Title',
            'Permissions',
        ];
    }
    public function query()
    {
        return Role::with('permissions')->whereIn('id',$this->selectedRows);
    }
}
