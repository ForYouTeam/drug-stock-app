<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WarehouseRequest;
use App\Models\Drug;
use App\Repositories\DrugRepository;
use App\Repositories\WarehouseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    private WarehouseRepository $wareHouse;
    private DrugRepository $drugRepo;

    public function __construct(WarehouseRepository $wareHouse, DrugRepository $drugRepo)
    {
        $this->wareHouse = $wareHouse;
        $this->drugRepo = $drugRepo;
    }

    public function index()
    {
        $drug = $this->drugRepo->getAllPayload([]);
        // $data = $this->getAllData();
        return view('Pages.Wherehouse')->with(['drug' => $drug['data']]);
    }

    public function getAllData(): JsonResponse
    {
        $data = $this->wareHouse->getAllPayload([]);

        return response()->json($data, $data['code']);
    }

    public function getDataById($id)
    {
        $data = $this->wareHouse->getByIdPayload($id);
        return response()->json($data, $data['code']);
    }

    public function upsertData(WarehouseRequest $request)
    {
        $payloadId = $request->id | null;
        $payload = array(
            'stock' => $request->stock,
            'drug_id' => $request->drug_id,
        );

        $data = $this->wareHouse->upsertPayload($payloadId, $payload);
        return response()->json($data, $data['code']);
    }

    public function deleteData($id)
    {
        $data = $this->wareHouse->deletePayload($id);
        return response()->json($data, $data['code']);
    }
}
