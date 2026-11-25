<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // READ ALL: GET /products (Web) & GET /api/products (API)
    public function index(Request $request)
    {
        $products = Product::all();

        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json([
                'data' => $products,
            ], 200);
        }

        return view('products', compact('products'));
    }

    // FORM CREATE: GET /products/create (Web)
    public function create()
    {
        return view('products.create');
    }

    // CREATE: POST /products (Web) & POST /api/products (API)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:100',
            'kategori'  => 'required|string|max:50',
            'harga'     => 'required|numeric|min:0',
            'stok'      => 'nullable|integer|min:0',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|string|max:255',
        ]);

        $product = Product::create($validated);

        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json([
                'message' => 'Produk berhasil ditambahkan.',
                'data'    => $product,
            ], 201);
        }

        return redirect()->route('products')->with('success', 'Produk berhasil ditambahkan.');
    }

    // READ DETAIL: GET /products/{id} (Web) & GET /api/products/{id} (API)
    public function show(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'message' => 'Produk tidak ditemukan.',
                ], 404);
            }
            abort(404);
        }

        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json([
                'data' => $product,
            ], 200);
        }

        return view('products.show', compact('product'));
    }

    // FORM EDIT: GET /products/{id}/edit (Web)
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    // UPDATE: PUT/PATCH /products/{id} (Web) & PUT/PATCH /api/products/{id} (API)
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'message' => 'Produk tidak ditemukan.',
                ], 404);
            }
            abort(404);
        }

        $validated = $request->validate([
            'nama'      => 'required|string|max:100',
            'kategori'  => 'required|string|max:50',
            'harga'     => 'required|numeric|min:0',
            'stok'      => 'nullable|integer|min:0',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|string|max:255',
        ]);

        $product->update($validated);

        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json([
                'message' => 'Produk berhasil diperbarui.',
                'data'    => $product,
            ], 200);
        }

        return redirect()->route('products')->with('success', 'Produk berhasil diperbarui.');
    }

    // DELETE: DELETE /products/{id} (Web) & DELETE /api/products/{id} (API)
    public function destroy(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'message' => 'Produk tidak ditemukan.',
                ], 404);
            }
            abort(404);
        }

        $product->delete();

        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json([
                'message' => 'Produk berhasil dihapus.',
            ], 200);
        }

        return redirect()->route('products')->with('success', 'Produk berhasil dihapus.');
    }
}
