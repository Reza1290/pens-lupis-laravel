<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanTugas extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function tugas(){
        return $this->belongsTo(Tugas::class,'tugas_id');
    }

    public function mahasiswa(){
        return $this->belongsTo(User::class,'mahasiswa_id');
    }
}
