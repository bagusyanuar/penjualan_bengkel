<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\DB;

class PenjualanController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = Penjualan::with([])->get();
            return $this->basicDataTables($data);
        }
        return view('penjualan.index');
    }

    public function add()
    {
        if ($this->request->method() === 'POST' && $this->request->ajax()) {
            try {
                $barang = Barang::find($this->postField('barang'));
                if ($barang->qty < (int)$this->postField('qty')) {
                    return $this->jsonResponse('Stok Kurang...', 500);
                }
                $data_request = [
                    'barang_id' => $this->postField('barang'),
                    'qty' => $this->postField('qty'),
                    'harga' => $this->postField('harga'),
                    'total' => ($this->postField('qty') * $this->postField('harga'))
                ];
                PenjualanDetail::create($data_request);
                return $this->jsonResponse('success', 200);
            } catch (\Exception $e) {
                return $this->jsonResponse('failed ' . $e->getMessage(), 500);
            }
        }
        if ($this->request->ajax()) {
            $data = PenjualanDetail::with(['barang'])->whereNull('penjualan_id')->get();
            return $this->basicDataTables($data);
        }

        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                $details = PenjualanDetail::with(['barang'])->whereNull('penjualan_id')->get();

                if (count($details) <= 0) {
                    return redirect()->back()->with('failed', 'Tidak ada barang dalam keranjang...');
                }

                $subTotal = $details->sum('total');
                $diskon = $this->postField('diskon');
                $terbayar = $this->postField('terbayar');
                $total = $subTotal - $diskon;
                $sisa = $total - $terbayar;

                $data_request = [
                    'customer' => $this->postField('customer'),
                    'tanggal' => $this->postField('tanggal'),
                    'no_nota' => $this->postField('no_nota'),
                    'keterangan' => $this->postField('keterangan'),
                    'sub_total' => $subTotal,
                    'diskon' => $diskon,
                    'total' => $total,
                    'terbayar' => $terbayar,
                    'sisa' => $sisa
                ];

                $penjualan = Penjualan::create($data_request);
                foreach ($details as $detail) {
                    $currentQty = $detail->barang->qty;
                    $qtyIn = $detail->qty;

                    if ($currentQty < $qtyIn) {
                        DB::rollBack();
                        return redirect()->back()->with('failed', 'stok kurang...');
                    }
                    $newQty = $currentQty + $qtyIn;

                    $detail->update([
                        'penjualan_id' => $penjualan->id
                    ]);

                    $detail->barang->update([
                        'qty' => $newQty
                    ]);
                }
                DB::commit();
                return redirect()->route('penjualan')->with('success', 'Berhasil Menambah Data Penjualan');
            } catch (\Exception $e) {
                dd($e->getMessage());
                DB::rollBack();
                return redirect()->back()->with('failed', 'terjadi kesalahan server...');
            }
        }

        $barang = Barang::all();
        return view('penjualan.add')->with([
            'barang' => $barang,
        ]);
    }

    public function detail_barang($id)
    {
        try {
            $data = Barang::with([])->where('id', '=', $id)->first();
            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function deleteCart($id)
    {
        try {
            PenjualanDetail::with([])->whereNull('penjualan_id')->where('id', '=', $id)->delete();
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }
}
