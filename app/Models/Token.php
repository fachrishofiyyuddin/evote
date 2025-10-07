<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = ['token', 'kelas', 'jurusan', 'used'];

    public function vote()
    {
        return $this->hasOne(Vote::class);
    }
}
