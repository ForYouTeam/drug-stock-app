<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionDetailRequest;
use App\Repositories\TransactionDetailRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionDetailController extends Controller
{
    private TransactionDetailRepository $repo;
    public function __construct(TransactionDetailRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $data = $this->getAllData();

        return view()->with('data', $data['data']);
    }

    public function getAllData(): JsonResponse
    {
        $data = $this->repo->getAllPayload([]);

        return response()->json($data, $data['code']);
    }

    public function getDataById($id)
    {
        $data = $this->repo->getByIdPayload($id);
        return response()->json($data, $data['code']);
    }

    public function upsertData(TransactionDetailRequest $request)
    {
        $payloadId = $request->id | null;
        $payload = array(
            'transaction_id' => $request->transaction_id,
            'in' => $request->in,
            'out' => $request->out,
            'request_amount' => $request->request_amount,
            'receive_amount' => $request->receive_amount,
            'drug_id' => $request->drug_id,
            'user_id' => $request->user_id,
        );

        $data = $this->repo->upsertPayload($payloadId ,$payload);
        return response()->json($data, $data['code']);
    }

    public function deleteData($id)
    {
        $data = $this->repo->deletePayload($id);
        return response()->json($data, $data['code']);
    }
}

