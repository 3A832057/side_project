<?php

namespace App\Http\Controllers\Back;
use App\Http\Controllers\Controller;
use App\Services\Back\ProductService;
use Illuminate\Http\Request;
use App\Http\Resources\Back\ProductResource;
use Illuminate\Support\Facades\DB;
class ProductImageController extends Controller
{
    
    protected ProductImageService $productImageService;

    public function __construct(ProductImageService $productImageService)
    {
        $this->productImageService = $productImageService;
    }

      

}
