<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //table name
    protected $tabel = 'posts';
    //primary key
    public $primaryKey = 'id';
    
    public $timestamps = 'true';
    
    //relationship model for blog and the user
    public function user(){
        return $this->belongsTo('App\User');
    }

}
