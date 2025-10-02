<?php

namespace App\Http\Controllers\Back;
use App\Http\Controllers\Controller;
use App\Services\Back\ProductService;
use Illuminate\Http\Request;
use App\Http\Resources\Back\ProductResource;

class ProductController extends Controller
{
    
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    //找產品資料表
    public function getDatatable(Request $request):array{

        $data = $request->all();

        // dd($data);
        $tableData = $this->productService->getDatatable($data);
        return ProductResource::collection($tableData)->response()->getData(true);

    }

    // 用id找單一產品資料
    public function find($id){

        try {
            $productData = $this->productService->find($id);

            return response()->json([
                'success' => $productData['success'],
                'message' => $productData['message'],
                'data' => $productData['data'],
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => '伺服器錯誤：' . $e->getMessage(),
                'data' => null,
            ], 500);
        }

    }

    // 更新產品資料
    public function update($id, Request $request){

        try {

            $productData = $this->productService->update($id , $request->all());

            return response()->json([
                'success' => $productData['success'],
                'message' => $productData['message'],
                'data' => $productData['data'],
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => '伺服器錯誤：' . $e->getMessage(),
                'data' => null,
            ], 500);
        }

    }
    
}
