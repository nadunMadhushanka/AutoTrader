<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rate extends Model
{
    use HasFactory;
    protected $table = 'rates';
    protected $primaryKey = 'id'; 
    protected $fillable = ['symbol','qty','side','rep_rate','status',];



    static function getRate($symbol, $side){
        //$status = DB::table('rates')->select('id','symbol','qty','side','rep_rate')->get();
        $rate = self::select('id','rep_rate','qty')->where('symbol', '=', $symbol)->where('side', '=', $side)->where('status','=',0)->get();
        return $rate;
        }

//if trade succeed then the status is 1 
    static function aditStatus($id){
        self::where('id',$id)->update(['status' => 1]);
    }

// if trade closed then the status is 2
    
    

    
}
