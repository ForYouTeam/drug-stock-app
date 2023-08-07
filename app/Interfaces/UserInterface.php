<?php

namespace App\Interfaces;

interface UserInterface {
  public function getAllPayload(array $query);
  public function getByIdPayload(int $paylaodId);
  public function upsertPayload($paylaodId, array $payload);
  public function deletePayload(int $paylaodId);
}