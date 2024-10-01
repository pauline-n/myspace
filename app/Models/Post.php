<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
     //creating a table name incase u dotn wnat the default table name given by laravel
     protected $table = 'posts';
     // same for promary key
     public $primaryKey = 'id';
     //adding the timestamps
     public $timestamps = true;

     public function user() {
          return $this->belongsTo(User::class); //means that a single post belongs to a user
     }

}
