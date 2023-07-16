<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\PembayaranHutang;
use App\Models\PembayaranPiutang;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Supplier;

class LaporanController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function pembelian()
    {
        if ($this->request->ajax()) {
            $tgl1 = $this->field('tgl1');
            $tgl2 = $this->field('tgl2');
            $data = Pembelian::with(['supplier'])
                ->whereBetween('tanggal', [$tgl1, $tgl2])
                ->orderBy('created_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('laporan.pembelian');
    }

    public function info_pembelian($id) {
        try {
            $data = Pembelian::with(['supplier', 'details.barang'])->where('id', '=', $id)->first();
            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function cetak_pembelian()
    {
        $tgl1 = $this->field('tgl1');
        $tgl2 = $this->field('tgl2');
        $data = Pembelian::with(['supplier'])
            ->whereBetween('tanggal', [$tgl1, $tgl2])
            ->orderBy('created_at', 'ASC')
            ->get();
        $html = view('cetak.pembelian')->with(['data' => $data, 'tgl1' => $tgl1, 'tgl2' => $tgl2]);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function penjualan()
    {
        if ($this->request->ajax()) {
            $tgl1 = $this->field('tgl1');
            $tgl2 = $this->field('tgl2');
            $data = Penjualan::with([])
                ->whereBetween('tanggal', [$tgl1, $tgl2])
                ->orderBy('created_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('laporan.penjualan');
    }

    public function info_penjualan($id) {
        try {
            $data = Penjualan::with(['details.barang'])->where('id', '=', $id)->first();
            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function cetak_penjualan()
    {
        $tgl1 = $this->field('tgl1');
        $tgl2 = $this->field('tgl2');
        $data = Penjualan::with([])
            ->whereBetween('tanggal', [$tgl1, $tgl2])
            ->orderBy('created_at', 'ASC')
            ->get();
        $html = view('cetak.penjualan')->with(['data' => $data, 'tgl1' => $tgl1, 'tgl2' => $tgl2]);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function hutang()
    {
        if ($this->request->ajax()) {
            $type = $this->field('type');
            if ($type === 'supplier') {
                $data = Supplier::with([])
                    ->get()->append(['hutang']);
                return $this->basicDataTables($data);
            }
            $tgl1 = $this->field('tgl1');
            $tgl2 = $this->field('tgl2');
            $data = PembayaranHutang::with(['supplier'])
                ->whereBetween('tanggal', [$tgl1, $tgl2])
                ->orderBy('tanggal', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('laporan.hutang');
    }

    public function cetak_hutang()
    {
        $type = $this->field('type');
        if ($type === 'supplier') {
            $data = Supplier::with([])
                ->get()->append(['hutang']);
            $html = view('cetak.hutang')->with(['data' => $data]);
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($html)->setPaper('a4', 'portrait');
            return $pdf->stream();
        }
        $tgl1 = $this->field('tgl1');
        $tgl2 = $this->field('tgl2');
        $data = PembayaranHutang::with(['supplier'])
            ->whereBetween('tanggal', [$tgl1, $tgl2])
            ->orderBy('tanggal', 'DESC')
            ->get();
        $html = view('cetak.pembayaran-hutang')->with(['data' => $data, 'tgl1' => $tgl1, 'tgl2' => $tgl2]);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function piutang()
    {
        if ($this->request->ajax()) {
            $type = $this->field('type');
            if ($type === 'penjualan') {
                $data = Penjualan::with([])
                    ->get()->append(['sisa_piutang'])->where('sisa_piutang','>',0)->values();
                return $this->basicDataTables($data);
            }
            $tgl1 = $this->field('tgl1');
            $tgl2 = $this->field('tgl2');
            $data = PembayaranPiutang::with(['penjualan'])
                ->whereBetween('tanggal', [$tgl1, $tgl2])
                ->orderBy('tanggal', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('laporan.piutang');
    }

    public function cetak_piutang()
    {
        $type = $this->field('type');
        if ($type === 'penjualan') {
            $data = Penjualan::with([])
                ->get()->append(['sisa_piutang'])->where('sisa_piutang','>',0)->values();
            $html = view('cetak.piutang')->with(['data' => $data]);
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($html)->setPaper('a4', 'portrait');
            return $pdf->stream();
        }
        $tgl1 = $this->field('tgl1');
        $tgl2 = $this->field('tgl2');
        $data = PembayaranPiutang::with(['penjualan'])
            ->whereBetween('tanggal', [$tgl1, $tgl2])
            ->orderBy('tanggal', 'DESC')
            ->get();
        $html = view('cetak.pembayaran-piutang')->with(['data' => $data, 'tgl1' => $tgl1, 'tgl2' => $tgl2]);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
