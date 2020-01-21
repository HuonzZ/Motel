<?php

namespace App\Http\Controllers;
use App\bookroom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BookroomController extends Controller
{
    public function thue(Request $request,$id){
        //dd($request->all());
        $them = new bookroom;
        $them ->id_user = Auth::user()->id;
        $them ->id_motelroom = $request->id_motelroom;
        $them ->startday =$request->startday;
        $them ->endday =$request->endday;
        $them ->number =$request->number;
        $them ->check =$request->check;
        $them ->save();
        return redirect('/');
    }
}
