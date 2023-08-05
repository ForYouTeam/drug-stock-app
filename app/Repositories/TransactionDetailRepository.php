<?php

namespace App\Repositories;

use App\Helper\ApiResponse;
use App\Interfaces\TransactionDetailInterface;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;

class TransactionDetailRepository implements TransactionDetailInterface
{
  public function getAllPayload($query)
  {
    try {
      $data = TransactionDetail::all();
      $meta = TransactionDetail::count();

      $response = ApiResponse::successRes($data, "success get data", 200, ['total' => $meta]);

    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get all payload | transaction_details");
    }

    return $response;
  }

  public function getByIdPayload(int $paylaodId)
  {
    try {
      $find = TransactionDetail::whereId($paylaodId)->first();
      
      if ($find) {
        $response = ApiResponse::successRes($find, "success get data", 200);
      } else {
        $response = ApiResponse::errRes("not found transaction detail", 404);
      }
      
    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get by id payload | transaction_details");
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
        $update   = TransactionDetail::whereId($paylaodId)->update($payload);
        $response = ApiResponse::successRes($update, "success update data", 200);

      } else {

        $payload['created_at'] = $date;
        $payload['updated_at'] = $date;
        $created  = TransactionDetail::create($payload);
        $response = ApiResponse::successRes($created, "success create data", 200);
      }

    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get upsert payload | transaction_details");
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

      $delete = TransactionDetail::whereId($paylaodId)->delete();

      $response = ApiResponse::successRes($delete, "success update data", 200);
    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get upsert payload | transaction_details");
    }
    
    return $response;
  }
}