<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Interfaces\ReceiverInterface;
use App\Interfaces\TransactionDetailInterface;
use App\Interfaces\TransactionInterface;
use App\Interfaces\WarehouseInterface;
use App\Repositories\ReceiverRepository;
use App\Repositories\TransactionDetailRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\WarehouseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    private TransactionInterface $transaksiRepo;
    private WarehouseInterface $warehouseRepo;
    private TransactionDetailInterface $transDetailRepo;
    private ReceiverInterface $receiverRepo;
    public function __construct()
    {
        $this->transaksiRepo   = new TransactionRepository      ;
        $this->warehouseRepo   = new WarehouseRepository        ;
        $this->transDetailRepo = new TransactionDetailRepository;
        $this->receiverRepo    = new ReceiverRepository         ;
    }

    public function index()
    {
        $data = [
            'warehouse' => $this->warehouseRepo->getAllPayload([])['data'],
            'receiver'  => $this->receiverRepo->getAllPayload([])['data']
        ];
        return view('Pages.Transactions')->with('data', $data);
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
      
        try {
            $totalCount = array_reduce($request->detail, function($carry, $item) {
                return $carry + $item["receive_amount"];
            }, 0);
            $transaction = $this->transaksiRepo->upsertPayload(null, [
                'receiver_id' =>  $request->receiver_id    ,
                'total_in'    => ($request->jenis_transaksi == 'in' ? $totalCount : 0),
                'total_out'   => ($request->jenis_transaksi == 'out' ? $totalCount : 0)
            ]);

            if ($transaction['code'] != 200) {
                return response()->json($transaction, $transaction['code']);
            }

            $savedDetails = [];

            foreach ($request->detail as $value) {
                $findWarehouse = $this->warehouseRepo->getByDrugId($value['drug_id']);

                if ($findWarehouse['code'] == 200) {
                    $newStock = $this->countStock($request['jenis_transaksi'], $value['request_amount'], $findWarehouse['data']['stock']);

                    $updatedPayload = [
                        'stock'   => $newStock     ,
                        'drug_id' => $findWarehouse['data']['drug_id']
                    ];

                    if ($newStock < 0) {
                        return response()->json(['message' => 'Data tidak dapat diproses, stok terlalu kecil'], 200); 
                    }

                    $warehouseId = $findWarehouse['data']['id'];
                    
                    $updatedPayload['stock'] = $newStock;
                    $this->warehouseRepo->upsertPayload($warehouseId, $updatedPayload);

                } else if ($findWarehouse['code'] == 404 && $request->jenis_transaksi != 'out') {
                    $updatedPayload = [
                        'stock'   => $value['receive_amount'],
                        'drug_id' => $value['drug_id'       ]
                    ];
                    $this->warehouseRepo->upsertPayload(null, $updatedPayload);
                    
                } else if($request->jenis_transaksi != 'out') {
                    return response()->json($findWarehouse, $findWarehouse['code']);
                }

                $saveTransaction = $this->transDetailRepo->upsertPayload(null, [
                    'transaction_id' => $transaction['data']['id'],
                    'in'  => ($request->jenis_transaksi == 'in'  ? $value['receive_amount'] : 0),
                    'out' => ($request->jenis_transaksi == 'out' ? $value['receive_amount'] : 0),
                    'request_amount' => $value['request_amount'],
                    'receive_amount' => $value['receive_amount'],
                    'drug_id' => $value['drug_id'],
                    'user_id' => Auth::user()->id ?? null,
                ]);

                array_push($savedDetails, $saveTransaction);
            }
            $result = [
                'transaction' => $transaction,
                'details' => $savedDetails
            ];

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'line'    => $th->getLine()
            ], 500);
        }

        return response()->json($result, 200);

    }

    public function deleteData($id)
    {
        $data = $this->transaksiRepo->deletePayload($id);
        return response()->json($data, $data['code']);
    }
}
