<?php

namespace App\MixService\Back;

use App\Services\Back\ProductImageService;
use App\Services\Back\ProductService;
use App\Services\Back\ProductSetService;
use App\Services\Back\ProductMaterialService;
use App\Services\Back\ProductGroupService;
use App\Services\Back\ComponentService;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductMixService
{
    protected ProductService $productService;
    protected ProductImageService $productImageService;
    protected ProductSetService $productSetService;
    protected ProductMaterialService $productMaterialService;
    protected ProductGroupService $productGroupService;

    protected ComponentService $componentService;
    public function __construct(ProductService $productService, ProductImageService $productImageService, ProductSetService $productSetService , ProductMaterialService $productMaterialService, ProductGroupService $productGroupService , ComponentService $componentService)
    {
        $this->productService = $productService;
        $this->productImageService = $productImageService;
        $this->productSetService = $productSetService;
        $this->productMaterialService = $productMaterialService;
        $this->productGroupService = $productGroupService;
        $this->componentService = $componentService;
    }
    public function store($product){

        $beforeData = null;
        $success = true;

        DB::beginTransaction();
        if($success) $productMain = $this->productService->store($product);
        $success = $productMain['success'];
        
        if($success) 
        {
            if(!empty($product['categories']))
                $productMain['data']->categories()->sync($product['categories']);
        }
        if($success) 
        {
           $this->productImageService->addProductImages($productMain['data'], $product);

        }
        
        if($success) 
        {

            $this->productGroupService->addProductGroup($productMain['data'], $product['set'] ?? []);

            $parentArr = [];
            $setModel = null;
            foreach ($product['set']['sets'] as $index => $set) {

                $setFirst = $set['first'] ?? null;
                $setSecond = $set['second'] ?? null;

                $newParent = $this->productSetService->addProductSet($productMain['data'], $set ,$parentArr);
                
                if ($newParent['first'] !== null) {
                    $parentArr[$index]['first'] = $newParent['first'] ?? null;
                    $parentArr[$index]['id'] = $newParent['id'] ?? null;
                }
                $setModel = $newParent['set'];

                foreach ($product['set']['set_material'] as $mIndex => $item) {

                    $itemFirst = $item['first'] ?? null;
                    $itemSecond = $item['second'] ?? null;

                    if ($setFirst !== $itemFirst || $setSecond !== $itemSecond) continue;

                    $this->productMaterialService->addProductMaterial($productMain['data'], $mIndex, $setModel , $item);

                }

            }
            
            
        }


        if($success) DB::commit();
        else DB::rollBack();
        
        $afterData = $this->productService->find($productMain['data']->id);
        $this->componentService->writeAdminLog('create', 'products', null, $afterData);

        return [
            'success' => $success,
            'message' => $productMain['message'],
            'data' => $success ? $productMain['data'] : null,
        ];
    }

    public function update($id, $product){

        $beforeData = $this->productService->find($id);
        $success = true;
        DB::beginTransaction();
        if($success) $successData = $this->productService->update($id, $product['product']);
        $success = $successData['success'];

        $productMain = Product::with([
            'categories',
            'images',
            'sets.materials',
            'groups',
        ])->find($id);

        if($success) 
        {
            if(!empty($product['categories']))
                $productMain->categories()->sync($product['categories']);
        }
        if($success) 
        {
            $this->productImageService->updateProductImages($productMain, $product['images']);
        }
        
        if($success) 
        {

            $this->productSetService->destroyByProductId($productMain->id);
            $this->productMaterialService->destroyByProductId($productMain->id);
            $this->productGroupService->destroyByProductId($productMain->id);


            $this->productGroupService->addProductGroup($productMain, $product['set'] ?? []);
            $parentArr = [];
            $setModel = null;
            
            foreach ($product['set']['sets'] as $index => $set) {

                $setFirst = $set['first'] ?? null;
                $setSecond = $set['second'] ?? null;

                $newParent = $this->productSetService->addProductSet($productMain, $set ,$parentArr);
                
                if ($newParent['first'] !== null) {
                    $parentArr[$index]['first'] = $newParent['first'] ?? null;
                    $parentArr[$index]['id'] = $newParent['id'] ?? null;
                }

                $setModel = $newParent['set'];

                foreach ($product['set']['set_material'] as $mIndex => $item) {
                    $itemFirst = $item['first'] ?? null;
                    $itemSecond = $item['second'] ?? null;

                    if ($setFirst !== $itemFirst || $setSecond !== $itemSecond) continue;

                    $this->productMaterialService->addProductMaterial($productMain, $mIndex, $setModel, $item);
                }

            }
            
        }


        if($success) DB::commit();
        else DB::rollBack();

        $afterData = $this->productService->find($id);
        $this->componentService->writeAdminLog('update', 'products', $beforeData, $afterData);
        return [
            'success' => $success,
            'message' => $successData['message'],
            'data' => $success ? $productMain : null,
        ];
    }
}