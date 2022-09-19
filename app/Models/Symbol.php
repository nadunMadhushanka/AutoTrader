<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symbol extends Model
{
    use HasFactory;
    protected $table = 'symbols';
    protected $primaryKey = 'id';
    protected $fillable = ['symbol'];


static function addSymbols($symbol){
    $repeatFlag = self::firstOrNew(['symbol' => $symbol]);
    $repeatFlag->save();
}

static function getSymbols(){
    $result = self::all();
    return $result;
}

}

