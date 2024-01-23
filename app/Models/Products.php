<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $fillable=['product_name','section_id','description'];
    public function section(){
          return $this->belongsTo('App\Models\Section');
    }

}
