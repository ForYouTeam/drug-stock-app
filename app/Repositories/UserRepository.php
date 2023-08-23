<?php

namespace App\Repositories;

use App\Helper\ApiResponse;
use App\Interfaces\UserInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
  public function getAllPayload($query)
  {
    try {
      $data = User::all();
      $meta = User::count();

      $response = ApiResponse::successRes($data, "success get data", 200, ['total' => $meta]);

    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get all payload | users");
    }

    return $response;
  }

  public function getByIdPayload(int $paylaodId)
  {
    try {
      $find = USer::whereId($paylaodId)->first();
      
      if ($find) {
        $response = ApiResponse::successRes($find, "success get data", 200);
      } else {
        $response = ApiResponse::errRes("not found users", 404);
      }
      
    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get by id payload | users");
    }

    return $response;
  }

  public function upsertPayload($paylaodId, array $payload)
  {
    try {
      $date = Carbon::now();
      $hash = Hash::make($payload['password']);
      if ($paylaodId) {

        $find = $this->getByIdPayload($paylaodId);
        if ($find['code'] !== 200) {
          return $find;
        }

        $payload['updated_at'] = $date;
        $payload['password'] = $hash;
        $update   = User::whereId($paylaodId)->update($payload);
        $response = ApiResponse::successRes($update, "success update data", 200);

      } else {

        $payload['created_at'] = $date;
        $payload['updated_at'] = $date;
        $payload['password'] = $hash;
        $created  = User::create($payload);
        $response = ApiResponse::successRes($created, "success create data", 200);
        $created->assignRole('admin');
      }

    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get upsert payload | users");
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

      $delete = User::whereId($paylaodId)->delete();

      $response = ApiResponse::successRes($delete, "success update data", 200);
    } catch (\Throwable $th) {
      $response = ApiResponse::errRes($th->getMessage(), 500, "get upsert payload | users");
    }
    
    return $response;
  }
}