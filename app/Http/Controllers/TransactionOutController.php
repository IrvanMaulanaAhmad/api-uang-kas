<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransactionOut;
use App\User;

class TransactionOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => 'OK',
            'code' => '200',
            'data' => TransactionOut::all()
        ], 200);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id_user' => 'required',
            'money' => 'required'
        ]);

        $trout = TransactionOut::create([
            'id_user' => $request->id_user,
            'money' => $request->money,
            'date' => date('Y-m-d'),
            'title' => $request->title,
            'reason' => $request->reason,
            'image' => $request->image
        ]);
        $user = User::find($request->id_user);
        $user->update([
            'balance' => $user->balance + $request->money
        ]);

        if($trout){
            return response()->json([
                'status' => 'OK',
                'code' => '200',
                'data' => $trout
            ]);
        }else{
            return response()->json([
                'status' => 'OK',
                'code' => '40',
                'message' => 'Unable to Store data'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trout = TransactionOut::find($id);
        return response()->json([
            'status' => 'OK',
            'code' => '200',
            'data' => $trin
        ]);
    }

    public function list($id)
    {
        $user = User::find($id);
        $trout = TransactionOut::where('id_user', $user->id)->get();
        return response()->json([
            'status' => 'OK',
            'code' => '200',
            'data' => $trout
        ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id_user' => 'required',
        ]);
        $trout = TransactionOut::find($id);
        if($request->has('money')){
            $user = User::find($request->id_user);
            $balance = $user->balance;
            $money = $trout->money;
            $newbalance = $balance + $money - $request->money;
            $trout->update([
                'id_user' => $request->id_user,
                'money' => $request->money
            ]);
            $user->update([
                'balance' => $newbalance
            ]);
        }
        if($request->has('title')){
            $trout->update([
                'title' => $request->title
            ]);
        }
        if($request->has('reason')){
            $trout->update([
                'reason' => $request->reason
            ]);
        }
        if($request->has('image')){
            $trout->update([
                'image' => $request->image
            ]);
        }
        return response()->json([
            'status' => 'OK',
            'code' => '200',
            'data' => $trout
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
