<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function products()
    {   
        $products = Products::latest()->paginate(6);
        return view('products',compact('products'));
    }
    public function addProduct(Request $request)
    {  
        // dd($request->all());
        $request->validate(
            [
                'name' => 'required|unique:products,name',
                'price' => 'required',
            ],
            [
                'name.required' =>'氏名を入力してください',
                'price.required' =>'価格を入力してください',
                'name.unique' =>'氏名が存在します'
            ]
        );
       
        $data = [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
        ];
        
        Products::create($data);
        return response()->json([
            'status' => 'success',
        ]);
    }
    public function updateProduct(Request $request)
    {  
        // dd($request->all());
        $request->validate(
            [
                'up_name' => 'required|unique:products,name,'.$request->up_id,
                'up_price' => 'required',
            ],
            [
                'up_name.required' =>'氏名を入力してください',
                'up_price.required' =>'価格を入力してください',
                'up_name.unique' =>'氏名が存在します'
            ]
        );
       
        $data = [
            'name' => $request->up_name,
            'price' => $request->up_price,
        ];
        
        Products::where('id',$request->up_id)->update($data);
        return response()->json([
            'status' => 'success',
        ]);
    }
    
}
