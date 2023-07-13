<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Supplier;

class SupplierController extends CustomController
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
                    'nama' => $this->postField('name'),
                    'no_hp' => $this->postField('no_hp'),
                    'alamat' => $this->postField('alamat'),
                ];
                Supplier::create($data_request);
                return $this->jsonResponse('success', 200);
            } catch (\Exception $e) {
                return $this->jsonResponse('failed ' . $e->getMessage(), 500);
            }
        }
        if ($this->request->ajax()) {
            $data = Supplier::all();
            return $this->basicDataTables($data);
        }
        return view('supplier.index');
    }

    public function patch($id)
    {
        try {
            $data = Supplier::find($id);
            $data_request = [
                'nama' => $this->postField('name'),
                'no_hp' => $this->postField('no_hp'),
                'alamat' => $this->postField('alamat'),
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
            Supplier::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}
