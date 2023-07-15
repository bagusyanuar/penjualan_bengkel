<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\PembayaranHutang;
use App\Models\Pembelian;
use App\Models\Supplier;
use Carbon\Carbon;

class PembayaranHutangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = PembayaranHutang::with(['supplier'])->orderBy('tanggal', 'DESC')->get();
            return $this->basicDataTables($data);
        }
        return view('pembayaran-hutang.index');
    }

    public function add()
    {
        if ($this->request->ajax()) {
            try {
                $supplierId = $this->field('supplier');
                $hutang = Pembelian::with([])->where('supplier_id', '=', $supplierId)
                    ->where('sisa', '>', 0)
                    ->get()->sum('sisa');
                $terbayar = PembayaranHutang::with([])->where('supplier_id', '=', $supplierId)
                    ->get()->sum('nominal');

                $sisa = $hutang - $terbayar;
                return $this->jsonResponse('success', 200, $sisa);
            }catch (\Exception $e) {
                return $this->jsonResponse('failed ' . $e->getMessage(), 500);
            }
        }

        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'supplier_id' => $this->postField('supplier'),
                    'no_transaksi' => 'PH-'.Carbon::now()->format('YmdHis'),
                    'tanggal' => $this->postField('tanggal'),
                    'nominal' => $this->postField('pembayaran'),
                    'keterangan' => $this->postField('keterangan')
                ];
                PembayaranHutang::create($data_request);
                return redirect()->route('pembayaran-hutang')->with('success', 'Berhasil Menambah Data Pembayaran Hutang');
            }catch (\Exception $e) {
                return redirect()->back()->with('failed', 'terjadi kesalahan server...');
            }

        }
        $supplier = Supplier::all();
        return view('pembayaran-hutang.add')->with([
            'supplier' => $supplier,
        ]);
    }

    public function destroy($id)
    {
        try {
            PembayaranHutang::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }
}
