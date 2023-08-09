<?php

namespace App\Repositories;

use App\Interfaces\WarehouseInterface;
use App\Helper\ApiResponse;
use App\Models\Warehouse;
use Carbon\Carbon;

class WarehouseRepository implements WarehouseInterface
{
  public function getAllPayload($query)
  {
    try {
      $data = Warehouse::with('drugs')->get();
      $meta = Warehouse::count();

      $response = ApiResponse::successRes($data, "success get data", 200, ['total' => $meta]);
    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get all payload | warehouses");
    }

    return $response;
  }

  public function getByIdPayload(int $paylaodId)
  {
    try {
      $find = Warehouse::whereId($paylaodId)->first();

      if ($find) {
        $response = ApiResponse::successRes($find, "success get data", 200);
      } else {
        $response = ApiResponse::errRes("not found warehouses", 404);
      }
    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get by id payload | warehouses");
    }

    return $response;
  }

  public function getByDrugId(int $paylaodId)
  {
    try {
      $find = Warehouse::where('drug_id', $paylaodId)->first();

      if ($find) {
        $response = ApiResponse::successRes($find, "success get data", 200);
      } else {
        $response = ApiResponse::errRes("not found warehouses", 404);
      }
    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get by drug id payload | warehouses");
    }
    
    return $response;
  }

  public function upsertPayload($paylaodId, array $payload)
  {
    try {
      $date = Carbon::now();

      if ($paylaodId) {

        $find = $this->getByIdPayload($paylaodId);
        if ($find['code'] !== 200) {
          return $find;
        }

        $payload['updated_at'] = $date;
        $update   = Warehouse::whereId($paylaodId)->update($payload);
        $response = ApiResponse::successRes($update, "success update data", 200);
      } else {

        $payload['created_at'] = $date;
        $payload['updated_at'] = $date;
        $created  = Warehouse::create($payload);
        $response = ApiResponse::successRes($created, "success create data", 200);
      }
    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get upsert payload | warehouses");
    }

    return $response;
  }

  public function deletePayload(int $paylaodId)
  {
    try {
      $find = $this->getByIdPayload($paylaodId);
      if ($find['code'] !== 200) {
        return $find;
      }

      $delete = Warehouse::whereId($paylaodId)->delete();

      $response = ApiResponse::successRes($delete, "success update data", 200);
    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get upsert payload | warehouses");
    }

    return $response;
  }
}
