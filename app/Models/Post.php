<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    //menambah mass assigment
    protected $fillable = [
        'nim', 'nama_mhs', 'nhp','alamat','image'
    ];
}
