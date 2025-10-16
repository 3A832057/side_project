<?php

namespace App\Http\Controllers\Back;
use App\Http\Controllers\Controller;
use App\Services\Back\ProductImageService;

class ProductImageController extends Controller
{
    
    protected ProductImageService $productImageService;

    public function __construct(ProductImageService $productImageService)
    {
        $this->productImageService = $productImageService;
    }

      

}
