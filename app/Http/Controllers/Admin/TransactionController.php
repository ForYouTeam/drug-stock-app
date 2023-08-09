<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Interfaces\TransactionDetailInterface;
use App\Repositories\TransactionDetailRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\WarehouseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    private TransactionRepository $transaksiRepo;
    private WarehouseRepository $warehouseRepo;
    private TransactionDetailRepository $transDetailRepo;
    public function __construct(TransactionRepository $transaksiRepo, WarehouseRepository $warehouseRepo, TransactionDetailRepository $transDetailRepo)
    {
        $this->transaksiRepo   = $transaksiRepo  ;
        $this->warehouseRepo   = $warehouseRepo  ;
        $this->transDetailRepo = $transDetailRepo;
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

    private function countStock(string $jenisTransaksi, $nowStock, $readyStock)
    {
        if ($jenisTransaksi == 'in') {
            $result = (int) $readyStock + (int) $nowStock;
        } else {
            $result = (int) $readyStock - (int) $nowStock;
        }
        
        return $result;
    }

    public function upsertData(TransactionRequest $request)
    {
        // return response()->json($request->all(), 200);
        try {
            $totalCount = array_reduce($request->detail, function($carry, $item) {
                return $carry + $item["receive_amount"];
            }, 0);

            $transaction = $this->transaksiRepo->upsertPayload(null, [
                'receiver_id' => $request->receiver_id,
                'total_in' => ($request->jenis_transaksi == 'in' ? $totalCount : 0),
                'total_out' => ($request->jenis_transaksi == 'out' ? $totalCount : 0)
            ]);

            if ($transaction['code'] != 200) {
                return $transaction;
            }

            foreach ($request->detail as $value) {
                $findWarehouse = $this->warehouseRepo->getByDrugId($value['drug_id'])['data'];
                $newStock = $this->countStock($request['jenis_transaksi'], $value['request_amount'], $findWarehouse['stock']);

                $updatedPayload = [
                    'stock' => $newStock,
                    'drug_id' => $findWarehouse['drug_id']
                ];

                if ($findWarehouse) {

                    if ($newStock < 0) {
                        return response()->json(['message' => 'Data tidak dapat diproses, stok terlalu kecil'], 500); 
                    }

                    $warehouseId = $findWarehouse['id'];
                    
                    $updatedPayload['stock'] = $newStock;
                    $this->warehouseRepo->upsertPayload($warehouseId, $updatedPayload);

                } else {
                    $this->warehouseRepo->upsertPayload(null, $updatedPayload);
                }

                $result = $this->transDetailRepo->upsertPayload(null, [
                    'transaction_id' => $transaction['data']['id'],
                    'in' => ($request->jenis_transaksi == 'in' ? $value['receive_amount'] : 0),
                    'out' => ($request->jenis_transaksi == 'out' ? $value['receive_amount'] : 0),
                    'request_amount' => $value['request_amount'],
                    'receive_amount' => $value['receive_amount'],
                    'drug_id' => $value['drug_id'],
                    'user_id' => Auth::user()->id ?? null,
                ]);

            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'line'    => $th->getLine()
            ], 500);
        }

        return response()->json($result, 200);

        // $payloadId = $request->id | null;
        // $payload = array(
        //     'jenis_transaksi' => $request->jenis_transaksi,
        //     'receiver_id'     => $request->receiver_id    ,
        // );

        // $data = $this->transaksiRepo->upsertPayload($payloadId ,$payload);
        // return response()->json($data, $data['code']);
    }

    public function deleteData($id)
    {
        $data = $this->transaksiRepo->deletePayload($id);
        return response()->json($data, $data['code']);
    }
}
