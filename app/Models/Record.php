<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Record extends Model
{
    use HasFactory;
    protected $table = 'record';
    protected $primaryKey = 'id';
    protected $fillable = ['symbol','price','qty','side'];


    static function getRecords(){
        $status = DB::table('record')->select('id','symbol', 'price','qty','side')->get();
      // $status = self::select()->whereColumn('symbol', 'price')->get();
        return $status;
        }

    }



