<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Kategori;

class BarangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST' && $this->request->ajax()) {
            try {
                $data_request = [
                    'kategori_id' => $this->postField('kategori'),
                    'nama' => $this->postField('name'),
                    'harga' => $this->postField('harga'),
                ];
                Barang::create($data_request);
                return $this->jsonResponse('success', 200);
            } catch (\Exception $e) {
                return $this->jsonResponse('failed ' . $e->getMessage(), 500);
            }
        }
        if ($this->request->ajax()) {
            $data = Barang::with(['kategori'])->get();
            return $this->basicDataTables($data);
        }
        $kategori = Kategori::all();
        return view('barang.index')->with(['kategori' => $kategori]);
    }

    public function patch($id)
    {
        try {
            $data = Barang::find($id);
            $data_request = [
                'kategori_id' => $this->postField('kategori'),
                'nama' => $this->postField('name'),
                'harga' => $this->postField('harga'),
            ];
            $data->update($data_request);
            return $this->jsonResponse('success', 200);
        }catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            Barang::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}
