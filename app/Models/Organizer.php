<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    // protected $connection = 'mongodb'; // optional if using MongoDB
    protected $collection = 'organizers'; // specify collection if needed
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'bio',
        'website',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
