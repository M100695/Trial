<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    //table name
    //protected $table = 'posts';
    //primary key
    //public $primarykey = 'id';

   // public timestamps = false;

   public function user()
   {
       return $this->belongsTo('App\User');
   }
}
