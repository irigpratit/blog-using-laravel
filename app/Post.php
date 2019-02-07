<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //table name
    // protected $tabel = 'posts';
    protected $fillable = ['title','body']; 
    //primary key
    public $primaryKey = 'id';
    
    public $timestamps = 'true';
    
    //relationship model for blog and the user
    public function user(){
        return $this->belongsTo('App\User');
    }

    // public function getPostImage(){
    //     if(!empty($this->cover_images)){
    //         $imagePath = '/storage/cover_images/'.$this->cover_images;
    //         return $imagePath;
    //     }else{
    //         return null;
    //     }
    // }


}
