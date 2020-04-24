<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\TransactionIn;
use App\TransactionOut;

class DashboardController extends Controller
{
    public function index()
    {
        $balance = User::all()->sum('balance');
        $trin = TransactionIn::all()->sum('money');
        $trout = TransactionOut::all()->sum('money');
        $data = [];
        try {
            return response()->json([
                'status' => 'OK',
                'code' => '200',
                'data' => [
                    'balance' => $balance,
                    'transaction-in' => $trin,
                    'transaction-out' => $trout,
                ]
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
