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
    protected $fillable = ['leverage','symbol','price','qty','side','rep_rate','status','order_id','order_price'];


    static function getPendingRecords(){
        $status = DB::table('record')->select('id','leverage','symbol', 'price','qty','side','rep_rate')->where('status','=',0)->get();
      // $status = self::select()->whereColumn('symbol', 'price')->get();
        return $status;
        }

    static function getSucceedRecords(){
          $status = DB::table('record')->select('id','leverage','symbol', 'price','qty','side','rep_rate','order_price','order_id')->where('status','=',1)->get();
        // $status = self::select()->whereColumn('symbol', 'price')->get();
          return $status;
          }

    static function getClosedRecords(){
            $status = DB::table('record')->select('id','leverage','symbol', 'price','qty','side','rep_rate','order_price','order_id')->where('status','=',2)->get();
          // $status = self::select()->whereColumn('symbol', 'price')->get();
            return $status;
            }
  


    static function aditStatus($id,$order_id,$entry_price){
          self::where('id',$id)->update(['status' => 1,'order_id'=>$order_id,'order_price'=>$entry_price]);
      }

      static function addClosedStatus($id){
        self::where('id',$id)->update(['status' => 2]);
    }

        

    }



