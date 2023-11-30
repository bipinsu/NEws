<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromQuery,WithMapping,WithHeadings
{
    use Exportable;

    protected $selectedRows;

    public function __construct($selectedRows)
    {
        $this->selectedRows=$selectedRows;
        
    }
    public function map($user):array
    {
        $roles = $user->roles->pluck('name')->implode(', ');
        return[
            $user->id,
            $user->name,
            $roles, 
            $user->email,
        ];
    }
    public function headings():array {
        return[
            'Id',
            'Title',
            'Role',
            'Email',
        ];
    }
    public function query()
    {
        return User::with('roles')->whereIn('id',$this->selectedRows);
    }
}
