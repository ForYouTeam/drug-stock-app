<?php

namespace App\Interfaces;

interface TransactionInterface {
  public function getAllPayload(array $query);
  public function getByIdPayload(int $paylaodId);
  public function upsertPayload($paylaodId, array $payload);
  public function deletePayload(int $paylaodId);
  public function exportByDateRange(array $payload);
}