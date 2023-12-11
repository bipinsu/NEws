<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavSubHeading extends Model
{
    use HasFactory;
    protected $fillable = ['nav_headings_id', 'name'];

    // Add any additional methods or relationships here if needed

    // Define the relationship with NavHeading
    public function navHeading()
    {
        return $this->belongsTo(NavHeading::class);
    }
}
