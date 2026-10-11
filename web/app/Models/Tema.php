<?php
// Historia: H-03, H-04, H-07, H-09

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $table = 'tema';
    protected $primaryKey = 'tema_id';
    public $timestamps = false;
    protected $guarded = ['*'];
}
