<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $table = 'absen';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kelas',
        'nama',
        'userlog',
        'clock_in',
        'tgl_clock_in',
        'clock_out',
        'tgl_clock_out',
        'latitude',
        'longitude',
        'lokasi',
    ];
}
