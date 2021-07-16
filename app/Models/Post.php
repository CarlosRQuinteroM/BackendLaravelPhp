<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // relacion con party
    public function party()
{
    return $this->belongsTo(Party::class);
}
  
    use HasFactory;
    protected $fillable =['title' ,'description'];

}
 
 

