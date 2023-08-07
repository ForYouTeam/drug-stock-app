<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReceiverRequest;
use App\Repositories\ReceiverRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReceiverController extends Controller
{
    private ReceiverRepository $repo;
    public function __construct(ReceiverRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $data = $this->getAllData([]);
        return view('Pages.Drugs')->with('data', $data);
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

    public function upsertData(ReceiverRequest $request)
    {
        $payloadId = $request->id | null;
        $payload = array(
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'alamat' => $request->alamat
        );

        $data = $this->repo->upsertPayload($payloadId, $payload);
        return response()->json($data, $data['code']);
    }

    public function deleteData($id)
    {
        $data = $this->repo->deletePayload($id);
        return response()->json($data, $data['code']);
    }
}
