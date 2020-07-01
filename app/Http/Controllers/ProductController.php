<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var Product
     */
    private $product;

    /**
     * ProductController constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getIndex()
    {
        return $this->product
            ->select('id', 'name as text', 'qty', 'sku', 'thumbnail')
            ->get();
    }
}
