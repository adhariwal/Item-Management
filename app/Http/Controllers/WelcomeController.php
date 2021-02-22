<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WelCome;

class WelcomeController extends Controller
{
    public function index()
    {

        
        $ProductListSelected = WelCome::GetProducts(1);
        $ProductListNonSelected = WelCome::GetProducts(0);
     
        return view('welcome')->with(['ProductListSelected' => $ProductListSelected, 'ProductListNonSelected' => $ProductListNonSelected]);
    }

    public function AddItem(Request $request ){
        $inputs = $request->all();
      
        if($inputs['name']){
          $AddData =  WelCome::AddItem($inputs['name']);
          return $AddData;
        }else{
            return "Something went wrong";
        }
    }

    public function GetData()
    {
        $ProductListNonSelected = WelCome::GetProducts(0);
     
        return json_decode($ProductListNonSelected);
    }

    public function RightToLeft(Request $request ){
        $inputs = $request->all();
        if($inputs['id']){
            WelCome::ItemSelcted($inputs['id'],1);
        }
        

    }

    public function LeftToRight(Request $request ){
        $inputs = $request->all();
        if($inputs['id']){
            WelCome::ItemSelcted($inputs['id'],0);
        }

    }

    
}