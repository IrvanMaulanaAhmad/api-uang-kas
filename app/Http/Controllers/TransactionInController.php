<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransactionIn;
use App\User;

class TransactionInController extends Controller
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
            'data' => TransactionIn::all()
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

        $trin = TransactionIn::create([
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

        if($trin){
            return response()->json([
                'status' => 'OK',
                'code' => '200',
                'data' => $trin
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
        $trin = TransactionIn::find($id);
        return response()->json([
            'status' => 'OK',
            'code' => '200',
            'data' => $trin
        ]);
    }

    public function list($id)
    {
        $user = User::find($id);
        $trin = TransactionIn::where('id_user', $user->id)->get();
        return response()->json([
            'status' => 'OK',
            'code' => '200',
            'data' => $trin
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
        $trin = TransactionIn::find($id);
        if($request->has('money')){
            $user = User::find($request->id_user);
            $balance = $user->balance;
            $money = $trin->money;
            $newbalance = $balance - $money + $request->money;
            $trin->update([
                'id_user' => $request->id_user,
                'money' => $request->money
            ]);
            $user->update([
                'balance' => $newbalance
            ]);
        }
        if($request->has('title')){
            $trin->update([
                'title' => $request->title
            ]);
        }
        if($request->has('reason')){
            $trin->update([
                'reason' => $request->reason
            ]);
        }
        if($request->has('image')){
            $trin->update([
                'image' => $request->image
            ]);
        }
        return response()->json([
            'status' => 'OK',
            'code' => '200',
            'data' => $trin
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
