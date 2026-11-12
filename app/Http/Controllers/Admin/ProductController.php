<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'seller'])->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'condition'   => 'required|in:brand_new,like_new,good,fair',
            'size'        => 'nullable|string',
            'brand'       => 'nullable|string',
            'stock'       => 'required|integer|min:0',
            'images.*'    => 'nullable|image|max:2048',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Simpan ke storage/app/public/products
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }

        Product::create([
            'user_id'     => auth()->id(),
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . Str::random(4),
            'description' => $request->description,
            'price'       => $request->price,
            'condition'   => $request->condition,
            'size'        => $request->size,
            'brand'       => $request->brand,
            'stock'       => $request->stock,
            'images'      => $images,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'condition'   => 'required|in:brand_new,like_new,good,fair',
            'stock'       => 'required|integer|min:0',
        ]);

        $images = $product->images ?? [];
        if ($request->hasFile('images')) {
            // Hapus gambar lama dari server
            if ($product->images) {
                foreach ($product->images as $oldImage) {
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }

            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }

        $product->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . Str::random(4),
            'description' => $request->description,
            'price'       => $request->price,
            'condition'   => $request->condition,
            'size'        => $request->size,
            'brand'       => $request->brand,
            'stock'       => $request->stock,
            'images'      => $images,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        // Hapus file gambar dari server
        if ($product->images) {
            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }
        
        $product->delete();
        return back()->with('success', 'Produk beserta file gambarnya berhasil dihapus.');
    }
}
