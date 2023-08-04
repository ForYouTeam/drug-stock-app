<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use App\Repositories\StaffRepository;
use App\Interfaces\StaffInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StaffController extends Controller
{
    private StaffRepository $repo;
    public function __construct(StaffRepository $repo)
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

    public function upsertData(StaffRequest $request)
    {
        $payloadId = $request->id | null;
        $payload = array(
            'name' => $request->name,
            'position' => $request->position,
            'user_id' => $request->user_id
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
