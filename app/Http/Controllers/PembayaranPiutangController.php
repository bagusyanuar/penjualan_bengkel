<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\PembayaranPiutang;
use App\Models\Penjualan;
use Carbon\Carbon;

class PembayaranPiutangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = PembayaranPiutang::with(['penjualan'])->orderBy('tanggal', 'DESC')->get();
            return $this->basicDataTables($data);
        }
        return view('pembayaran-piutang.index');
    }

    public function add()
    {
        if ($this->request->ajax()) {
            try {
                $penjualanId = $this->field('penjualan');
                $piutang = Penjualan::with([])
                    ->where('sisa', '>', 0)
                    ->where('id', '=', $penjualanId)
                    ->first();
                $sisa = 0;
                if ($piutang !== null) {
                    $piutang = $piutang->append(['pelunasan', 'sisa_piutang']);
                    $sisa = $piutang->sisa_piutang;
                }
                return $this->jsonResponse('success', 200, $sisa);
            } catch (\Exception $e) {
                return $this->jsonResponse('failed ' . $e->getMessage(), 500);
            }
        }
//
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'penjualan_id' => $this->postField('penjualan'),
                    'no_transaksi' => 'PH-' . Carbon::now()->format('YmdHis'),
                    'tanggal' => $this->postField('tanggal'),
                    'nominal' => $this->postField('pembayaran'),
                    'keterangan' => $this->postField('keterangan')
                ];
                PembayaranPiutang::create($data_request);
                return redirect()->route('pembayaran-piutang')->with('success', 'Berhasil Menambah Data Pembayaran Piutang');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'terjadi kesalahan server...');
            }

        }
        $piutang = Penjualan::with([])
            ->where('sisa', '>', 0)
            ->get()->append(['pelunasan', 'sisa_piutang'])->where('sisa_piutang', '>', 0)->values();
        return view('pembayaran-piutang.add')->with([
            'piutang' => $piutang,
        ]);
    }
}
