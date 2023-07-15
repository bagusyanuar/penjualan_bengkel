<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

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

    public function info($id) {
        try {
            $data = Pembelian::with(['supplier', 'details.barang'])->where('id', '=', $id)->first();
            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
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
            $data = PembelianDetail::with(['barang'])->whereNull('pembelian_id')->get();
            return $this->basicDataTables($data);
        }

        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                $details = PembelianDetail::with(['barang'])->whereNull('pembelian_id')->get();
                if (count($details) <= 0) {
                    return redirect()->back()->with('failed', 'Tidak ada barang dalam keranjang...');
                }
                $subTotal = $details->sum('total');
                $diskon = $this->postField('diskon');
                $terbayar = $this->postField('terbayar');
                $total = $subTotal - $diskon;
                $sisa = $total - $terbayar;

                $data_request = [
                    'supplier_id' => $this->postField('supplier'),
                    'tanggal' => $this->postField('tanggal'),
                    'no_nota' => $this->postField('no_nota'),
                    'keterangan' => $this->postField('keterangan'),
                    'sub_total' => $subTotal,
                    'diskon' => $diskon,
                    'total' => $total,
                    'terbayar' => $terbayar,
                    'sisa' => $sisa
                ];

                $pembelian = Pembelian::create($data_request);
                foreach ($details as $detail) {
                    $currentQty = $detail->barang->qty;
                    $qtyIn = $detail->qty;
                    $newQty = $currentQty + $qtyIn;

                    $detail->update([
                        'pembelian_id' => $pembelian->id
                    ]);

                    $detail->barang->update([
                        'qty' => $newQty
                    ]);
                }
                DB::commit();
                return redirect()->route('pembelian')->with('success', 'Berhasil Menambah Data Pembelian');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'terjadi kesalahan server...');
            }
        }
        $supplier = Supplier::all();
        $barang = Barang::all();
        return view('pembelian.add')->with([
            'supplier' => $supplier,
            'barang' => $barang,
        ]);
    }

    public function deleteCart($id)
    {
        try {
            PembelianDetail::with([])->whereNull('pembelian_id')->where('id', '=', $id)->delete();
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }
}
