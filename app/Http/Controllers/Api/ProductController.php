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

    //create new product
    public function create(Request $request){
        //for validating required fields
        $validateProduct = Validator::make($request->all(),[
            'product_name'=> 'required|unique:products,product_name',
            'quantity'=>'required|numeric',
            'price'=> 'required|decimal:0,2'
        ]);
        //error message if validation fails
        if($validateProduct->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'data' => $validateProduct->errors()
            ],422);
        }
        //if validation is successful, create an array of the incoming data;
        $inputData = array(
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            //the {isset} is responsible for checking if a variable is set is not null;
            //the {isset} function returns false if  the variable being checked is null;
            'description' => isset($request->description) ? $request->description: '',
        );
        //create new product using Products model
        $product = Product::create($inputData);
        //return success response
        return response()->json([
            'status'=> true,
            'message'=> 'Product created successfully!',
            'data'=> $product
        ],200);
    }

    //update product
    public function update(Request $request){
        //for validating required fields
        $validateProduct = Validator::make($request->all(),[
            'product_id'=> 'required|exists:products,id',
            'product_name'=> 'required',
            'quantity'=>'required|numeric',
            'price'=> 'required|decimal:0,2'
        ]);
        //error message if validation fails
        if($validateProduct->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'data' => $validateProduct->errors()
            ],422);
        }

        //find product with the id using Products model
        $product = Product::find($request->product_id);
        //update product fields
        $product->product_name = $request->product_name;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->description = isset($request->description) ? $request->description: '';
        //save product
        $product->save();
        //return success response
        return response()->json([
            'status'=> true,
            'message'=> 'Product updated successfully!',
            'data'=> $product
        ],200);
    }

    //delete product
    public function delete(Request $request){
        //for validating required fields
        $validateProduct = Validator::make($request->all(),[
            'product_id'=> 'required|exists:products,id'
        ]);
        //error message if validation fails
        if($validateProduct->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'data' => $validateProduct->errors()
            ],422);
        }

        //find product with the id using Products model and delete
        $product = Product::find($request->product_id)->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Product deleted successfully!',
        ],200);
    }

     //search listings
     public function search(Request $request){
        $products = Product::where('product_name','!=','');
        if(isset($request->product_name) && $request->product_name != ''){
            $products = $products->where('product_name', $request->product_name);
        };
        if(isset($request->quantity) && $request->quantity != ''){
            $products = $products->where('quantity', $request->quantity);
        };
        $products = $products->paginate(2);
        return response()->json([
            'status'=> true,
            'message'=> 'Products listed successfully',
            'data'=> $products
        ],200);
        // echo "jsbjdjdd"; die;
    }
}
