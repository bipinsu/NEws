<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'nav_headings_id',
        'nav_sub_headings_id',
        'title',
        'description',
        'image',
    ];

    // Add any additional methods or relationships here if needed

    // Define the relationship with NavHeading
    public function navHeading()
    {
        return $this->belongsTo(NavHeading::class, 'nav_headings_id');
    }

    // Define the relationship with NavSubHeading
    public function navSubHeading()
    {
        return $this->belongsTo(NavSubHeading::class, 'nav_sub_headings_id');
    }
    public function images()
{
   return $this->hasMany(NewsImage::class);
}
}
