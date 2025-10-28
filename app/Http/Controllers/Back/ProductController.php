<?php

namespace App\Http\Controllers\Back;
use App\Http\Controllers\Controller;
use App\MixService\Back\ProductMixService;
use App\Services\Back\ProductService;
use App\Services\Back\ComponentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Resources\Back\ProductResource;
class ProductController extends Controller
{
    protected ComponentService $componentService;
    protected ProductService $productService;
    protected ProductMixService $productMixService;
    public function __construct(ProductService $productService, ProductMixService $productMixService, ComponentService $componentService)
    {
        $this->productService = $productService;
        $this->productMixService = $productMixService;
        $this->componentService = $componentService;
    }

    //找產品資料表
    public function getDatatable(Request $request):array{

        $data = $request->all();

        $tableData = $this->productService->getDatatable($data);
        return ProductResource::collection($tableData)->response()->getData(true);

    }

    public function get(){

        try {

            $allData = $this->productService->get();

            return response()->json([
                'success' => $allData['success'],
                'message' => $allData['message'],
                'data' => $allData['data'],
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => '伺服器錯誤：' . $e->getMessage(),
                'data' => null,
            ], 500);
        }

        
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

    // 更新產品資料(主檔)
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

    // 修改產品資料(全部包括材料、類別)
    public function updateAll($id, Request $request){

        try {

            
            $productData = $this->productMixService->update($id , $request->all());

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
    // 新增產品資料(全部包括材料、類別)
    public function store(Request $request){
        try {
            $product = $request->all();

            $productMain = $this->productMixService->store($product);

            return response()->json([
                'success' => $productMain['success'],
                'message' => $productMain['message'],
                'data' => $productMain['data'],
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
