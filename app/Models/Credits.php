<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credits extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function dosen(){
        return $this->belongsTo(User::class,'dosen_id');
    }
    
    public function matkul(){
        return $this->belongsTo(MataKuliah::class,'matkul_id');
    }

    public function kelas(){
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
