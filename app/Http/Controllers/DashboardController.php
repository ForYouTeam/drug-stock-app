<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\Receiver;
use App\Models\Transaction;
use App\Models\Warehouse;
use App\Repositories\DrugRepository;
use App\Repositories\ReceiverRepository;
use App\Repositories\TransactionDetailRepository;
use App\Repositories\WarehouseRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // private DrugRepository $drugRepo;
    // private WarehouseRepository $warehouseRepo;
    // private TransactionDetailRepository $transRepo;
    // private ReceiverRepository $receiveRepo;

    // public function __construct(DrugRepository $drugRepo, WarehouseRepository $warehouseRepo, TransactionDetailRepository $transRepo, ReceiverRepository $receiveRepo) 
    // {
    //     $this->drugRepo = $drugRepo;
    //     $this->warehouseRepo = $warehouseRepo;
    //     $this->transRepo = $transRepo;
    //     $this->receiveRepo = $receiveRepo;
    // }
    public function index()
    {
        $data = [
            'obat'      => Drug::count(),
            'gudang'    => Warehouse::count(),
            'penerima'  => Receiver::count(),
            'transaksi' => Transaction::count()
        ];
        
        return view('Pages.Dashboard')->with('data', $data);
    }
}
