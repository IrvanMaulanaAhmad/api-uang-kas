<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\TransactionIn;
use App\TransactionOut;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //
    }

    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'code' => '200',
            'data' => User::all()
        ]);
    }

    public function show($id)
    {
        $data = User::find($id);
        $trin = TransactionIn::where('id_user', $id)->sum('money');
        $trout = TransactionOut::where('id_user', $id)->sum('money');
        if($data == null){
            return response()->json([
                'status' => 'OK',
                'code' => '404',
                'message' => 'No Data'
            ]);
        }else{
            return response()->json([
                'status' => 'OK',
                'code' => '200',
                'data' => [
                    'id' => $data->id,
                    'username' => $data->username,
                    'balance' => $data->balance,
                    'transaction-in' => $trin,
                    'transaction-out' => $trout,
                    'status' => $data->status,
                    'created_at' => $data->created_at,
                    'updated_at' => $data->updated_at
                ]
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        // only allowed to change Users status
        $this->validate($request, [
            'status' => 'required'
        ]);
        $user = User::find($id);
        $user->update([
            'status' => $request->status
        ]);

    }
}
