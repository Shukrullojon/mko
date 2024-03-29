<?php

namespace App\Http\Controllers\Pages;

use App\Exports\ExportClient;
use App\Http\Controllers\Controller;
use App\Models\Pages\Client;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:client.index'])->only('index');
        $this->middleware(['auth','permission:client.show'])->only('show');
    }

    public function index(Request $request)
    {
        $clients = Client::latest()->paginate(20);
        return view('pages.client.index', [
            'clients' => $clients,
        ]);
    }

    public function show($id){
        $client = Client::find($id);
        return view('pages.client.show',[
            'client' => $client
        ]);
    }

    public function exportClient() {
        return Excel::download(new ExportClient(), 'Kлиенты.xlsx');
    }
}
