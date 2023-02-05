<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Rules\CheckAvailableStock;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function order(Request $request){

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:product,id',
            'quantity'  => ['required','integer','min:1', new CheckAvailableStock($request->product_id)],
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = Product::find($request->product_id);
        $product->available_stock = $product->available_stock - $request->quantity;
        $product->save();

        return response()->json([
            'message' => 'You have succesfully ordered this product'
        ], 201);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
