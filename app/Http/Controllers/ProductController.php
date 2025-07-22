<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
class ProductController extends Controller
{
    public function index()
    {
    $products = Product::latest()->get(); // Busca os produtos
    return view('products.index', ['products' => $products]);
    }

    public function create()
    {
        // Lógica para mostrar o formulário de criação de produto
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Lógica para salvar um novo produto
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso!');
    }
    public function edit(Product $product)
    {
        // Lógica para mostrar o formulário de edição de produto
        return view('products.edit', compact('product'));
    }
    public function update(Request $request, Product $product)
    {
        // Lógica para atualizar um produto existente
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }
    public function destroy(Product $product)
    {
        // Lógica para deletar um produto
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produto deletado com sucesso!');
    }
    public function syncProducts(Request $request, Customer $customer)
    {
        // Lógica para sincronizar produtos com um cliente
        $validated = $request->validate([
            'product_ids' => 'array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $customer->products()->sync($validated['product_ids']);

        return redirect()->route('customers.edit', $customer->id)
                         ->with('success', 'Produtos sincronizados com sucesso!');
    }
}
