<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepository $repo;
    public function __construct(UserRepository $repo)
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

    public function upsertData(UserRequest $request)
    {
        $payloadId = $request->id | null;
        $payload = array(
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'scope' => $request->scope
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
