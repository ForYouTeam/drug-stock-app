<?php

namespace App\Repositories;

use App\Exports\TransactionExport;
use App\Helper\ApiResponse;
use App\Interfaces\TransactionInterface;
use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class TransactionRepository implements TransactionInterface
{
  public function getAllPayload($query)
  {
    try {
      $data = Transaction::with('receiver')->get();
      $meta = Transaction::count();

      $response = ApiResponse::successRes($data, "success get data", 200, ['total' => $meta]);

    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get all payload | transactions");
    }

    return $response;
  }

  public function getByIdPayload(int $paylaodId)
  {
    try {
      $find = Transaction::whereId($paylaodId)->first();
      
      if ($find) {
        $response = ApiResponse::successRes($find, "success get data", 200);
      } else {
        $response = ApiResponse::errRes("not found transaction", 404);
      }
      
    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get by id payload | transactions");
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
        $update   = Transaction::whereId($paylaodId)->update($payload);
        $response = ApiResponse::successRes($update, "success update data", 200);

      } else {

        $payload['created_at'] = $date;
        $payload['updated_at'] = $date;
        $created  = Transaction::create($payload);
        $response = ApiResponse::successRes($created, "success create data", 200);
      }

    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get upsert payload | transactions");
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

      $delete = Transaction::whereId($paylaodId)->delete();

      $response = ApiResponse::successRes($delete, "success update data", 200);
    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get upsert payload | transactions");
    }
    
    return $response;
  }

  public function exportByDateRange($payload)
    {
        $startDate = $payload['start_date'];
        $endDate = $payload['end_date'];
        $data = Transaction::whereBetween('created_at', [$startDate, $endDate])->with('receiver')->get();
        return $data;
    }
}