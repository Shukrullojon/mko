<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $table = 'histories';
    protected $guarded = [];

    public static function saver($data){
        foreach ($data as $d) {
            $history = History::where('numberTrans', $d['numberTrans'])->firstOrNew();
            $history->fill([
                'date' => $d['date'],
                'dtAcc' => $d['dtAcc'],
                'dtAccName' => $d['dtAccName'],
                'dtMfo' => $d['dtMfo'],
                'purpose' => $d['purpose'],
                'debit' => $d['debit'] * 100,
                'credit' => $d['credit'] * 100,
                'numberTrans' => $d['numberTrans'],
                'type' => $d['type'],
                'ctAcc' => $d['ctAcc'],
                'ctAccName' => $d['ctAccName'],
                'ctMfo' => $d['ctMfo'],
            ]);
            $history->save();
        }
    }
}
