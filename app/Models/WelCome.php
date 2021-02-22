<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class WelCome extends Model
{
    use HasFactory;

    public static  function GetProducts($Selected=0){

      $products =  DB::table('products')->where('selected',$Selected)->get();

      return $products;

    }


    public static  function AddItem($name){

        $productCount =  DB::table('products')->where('product_name',$name)->count();

        if($productCount == 0){
        DB::insert('insert into products (product_name) values (?)', [$name]);
        return 1;
        }else{
         return 0;
        }
        
    }

    public static  function ItemSelcted($id , $select){
        DB::table('products')->where('id', $id)->update(['selected' => $select]);
    }


}