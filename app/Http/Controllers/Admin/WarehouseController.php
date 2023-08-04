<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WarehouseRequest;
use App\Repositories\WarehouseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    private WarehouseRepository $repo;
    public function __construct(WarehouseRepository $repo)
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

    public function upsertData(WarehouseRequest $request)
    {
        $payloadId = $request->id | null;
        $payload = array(
            'stock' => $request->stock,
            'drug_id' => $request->drug_id,
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