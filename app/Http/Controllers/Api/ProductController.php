<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //Product listings
    public function index(Request $request){
        $products = Product::all();
        return response()->json([
            'status'=> true,
            'message'=> 'Products listed successfully',
            'data'=> $products
        ],200);
        // echo "jsbjdjdd"; die;
    }

    public function create(Request $request){
        //for validating required fields
        $validateProduct = Validator::make($request->all(),[
            'product_name'=> 'required|unique:products,product_name',
            'quantity'=>'required|numeric',
            'price'=> 'required|decimal:0,2'
        ]);
        if($validateProduct->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'data' => $validateProduct->errors()
            ]);
        }
       /*  return response()->json([
            'status'=> true,
            'message'=> 'Products listed successfully',
            'data'=> $product
        ],200); */
    }
}
