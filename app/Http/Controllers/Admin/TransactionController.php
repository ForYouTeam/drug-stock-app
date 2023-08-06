<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Repositories\TransactionRepository;
use App\Repositories\WarehouseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private TransactionRepository $transaksiRepo;
    private WarehouseRepository $warehouseRepo;
    public function __construct(TransactionRepository $transaksiRepo, WarehouseRepository $warehouseRepo)
    {
        $this->transaksiRepo = $transaksiRepo;
        $this->warehouseRepo = $warehouseRepo;
    }

    public function index()
    {
        $warehouse = $this->warehouseRepo->getAllPayload([]);
        return view('Pages.Transactions')->with('warehouse', $warehouse['data']);
    }

    public function getAllData(): JsonResponse
    {
        $data = $this->transaksiRepo->getAllPayload([]);

        return response()->json($data, $data['code']);
    }

    public function getDataById($id)
    {
        $data = $this->transaksiRepo->getByIdPayload($id);
        return response()->json($data, $data['code']);
    }

    public function upsertData(TransactionRequest $request)
    {
        $payloadId = $request->id | null;
        $payload = array(
            'warehouse_id' => $request->warehouse_id,
            'receiver_id' => $request->receiver_id,
            'total_in' => $request->total_in,
            'total_out' => $request->total_out
        );

        $data = $this->transaksiRepo->upsertPayload($payloadId ,$payload);
        return response()->json($data, $data['code']);
    }

    public function deleteData($id)
    {
        $data = $this->transaksiRepo->deletePayload($id);
        return response()->json($data, $data['code']);
    }
}
