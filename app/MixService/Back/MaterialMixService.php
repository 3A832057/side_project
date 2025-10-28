<?php

namespace App\MixService\Back;

use App\Services\Back\MaterialService;
use App\Services\Back\MaterialQuantityLogService;
use App\Services\Back\ComponentService;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class MaterialMixService
{
    protected MaterialQuantityLogService $materialQuantityLogService;
    protected MaterialService $materialService;

    protected ComponentService $componentService;
    public function __construct(MaterialQuantityLogService $materialQuantityLogService, MaterialService $materialService , ComponentService $componentService)
    {
        $this->materialQuantityLogService = $materialQuantityLogService;
        $this->materialService = $materialService;
        $this->componentService = $componentService;
    }
    public function quantityUpdate($logData){

        $success = true;

        DB::beginTransaction();

        $data['quantity'] = $logData['after'];
        $materialMain = $this->materialService->update($logData['material_id'] , $data );
        $success = $materialMain['success'];

        
        if($success){
            $material= $this->materialQuantityLogService->store($logData);
            $success = $material['success'];
        }

        if($success) DB::commit();
        else DB::rollBack();
        
        $afterData = $this->materialQuantityLogService->find($materialMain['data']->id);
        $this->componentService->writeAdminLog('create', 'products', null, $afterData);

        return [
            'success' => $success,
            'message' => $materialMain['message'],
            'data' => $success ? $materialMain['data'] : null,
        ];
    }


}