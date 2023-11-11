<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailCredit extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function sks(){
        return $this->belongsTo(Credits::class,'credits_id');
    }

    public function mahasiswa(){
        return $this->belongsTo(User::class,'mahasiswa_id');
    }


}
