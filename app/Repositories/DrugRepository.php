<?php

namespace App\Repositories;

use App\Interfaces\DrugInterface;
use App\Helper\ApiResponse;
use App\Models\Drug;
use Carbon\Carbon;

class DrugRepository implements DrugInterface
{
  public function getAllPayload($query)
  {
    try {
      $data = Drug::all();
      $meta = Drug::count();

      $response = ApiResponse::successRes($data, "success get data", 200, ['total' => $meta]);

    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get all payload | drugs");
    }

    return $response;
  }

  public function getByIdPayload(int $paylaodId)
  {
    try {
      $find = Drug::whereId($paylaodId)->first();
      
      if ($find) {
        $response = ApiResponse::successRes($find, "success get data", 200);
      } else {
        $response = ApiResponse::errRes("not found drugs", 404);
      }
      
    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get by id payload | drugs");
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
        $update   = Drug::whereId($paylaodId)->update($payload);
        $response = ApiResponse::successRes($update, "success update data", 200);

      } else {

        $payload['created_at'] = $date;
        $payload['updated_at'] = $date;
        $created  = Drug::create($payload);
        $response = ApiResponse::successRes($created, "success create data", 200);
      }

    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get upsert payload | drugs");
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

      $delete = Drug::whereId($paylaodId)->delete();

      $response = ApiResponse::successRes($delete, "success update data", 200);
    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get upsert payload | drugs");
    }
    
    return $response;
  }
}