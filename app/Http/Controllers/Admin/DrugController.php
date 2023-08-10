<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DrugRequest;
use App\Interfaces\DrugInterface;
use App\Models\Drug;
use App\Repositories\DrugRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    private DrugRepository $repo;
    public function __construct(DrugRepository $repo)
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

    public function searchDrug(Request $request){
        $term = $request->input('term'); // Ambil kata kunci pencarian dari permintaan

        // Lakukan pencarian berdasarkan kata kunci
        $results = Drug::where('name', 'LIKE', "%$term%")->get();

        return response()->json($results, 200);
    }

    public function upsertData(DrugRequest $request)
    {
        $payloadId = $request->id | null;
        $payload = array(
            'name' => $request->name
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
