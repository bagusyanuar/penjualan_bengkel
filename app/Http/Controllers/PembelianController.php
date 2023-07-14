<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Supplier;

class PembelianController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = Pembelian::with(['supplier'])->get();
            return $this->basicDataTables($data);
        }
        return view('pembelian.index');
    }

    public function add()
    {
        if ($this->request->method() === 'POST' && $this->request->ajax()) {
            try {
                $data_request = [
                    'barang_id' => $this->postField('barang'),
                    'qty' => $this->postField('qty'),
                    'harga' => $this->postField('harga'),
                    'total' => ($this->postField('qty') * $this->postField('harga'))
                ];
                PembelianDetail::create($data_request);
                return $this->jsonResponse('success', 200);
            } catch (\Exception $e) {
                return $this->jsonResponse('failed ' . $e->getMessage(), 500);
            }
        }
        if ($this->request->ajax()) {
            $data = PembelianDetail::with(['barang'])->get();
            return $this->basicDataTables($data);
        }
        $supplier = Supplier::all();
        $barang = Barang::all();
        return view('pembelian.add')->with([
            'supplier' => $supplier,
            'barang' => $barang,
        ]);
    }
}
