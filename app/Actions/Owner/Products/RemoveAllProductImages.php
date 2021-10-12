<?php

namespace App\Actions\Owner\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class RemoveAllProductImages
{
    public function handle(Product $product)
    {
        Storage::disk('public')
            ->deleteDirectory("img/places/{$product->cafe->name}/products/product-$product->id");

        $product->images()->delete();
    }
}
