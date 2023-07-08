<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Faker\Provider\HtmlLorem;
use Faker\Provider\Lorem;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index($id = null)
    {
        if ($id) {
            $product = Products::find($id);
            if (!$product) {
                return response()->json(['message' => 'Produto não encontrado'], 404);
            }
            return response()->json($product);
        }

        $product = Products::all();
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string',
            'brand' => 'required|string',
            'description' => 'required|string',
            'voltage' => 'required|string',
        ]);
           
        $existingProduct = Products::where('product_name', $validated['product_name'])->first();
    
        if ($existingProduct) {
            return response()->json(['message' => 'Usuário já cadastrado'], 409);
        }
    
        $product = Products::create($validated);
    
        return response()->json(['message' => 'Usuário cadastrado com sucesso!', 'user' => $product], 201);
    }

    public function update(Request $request, Products $product)
    {
        $validated = $request->validate([
            'product_name' => 'nullable|string',
            'brand' => 'nullable|string',
            'description' => 'nullable|string',
            'voltage' => 'nullable|string',
        ]);
       

        $product->update($validated);

        return response()->json(['message' => 'Dados atualizados com êxito!']);
    }

    public function destroy(Products $product)
    {
        $product->delete();
        return response()->json(['message' => 'Produto excluído com sucesso!']);
    }


}