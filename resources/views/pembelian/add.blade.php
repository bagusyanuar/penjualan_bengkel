@extends('layout')

@section('css')
    <style>
        .swal2-shown {
            overflow: unset !important;
            padding-right: 0px !important;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Tambah Pembelian</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('pembelian') }}">Pembelian</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Pembelian
            </li>
        </ol>
    </div>
    <div class="w-100 p-2">
        <div class="card card-outline card-info">
            <div class="card-header">
                <div class="text-left mb-2">
                    <p class="font-weight-bold">Form Tambah Pembelian</p>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="form-group w-100">
                            <label for="supplier">Supplier</label>
                            <select class="form-control" id="supplier" name="supplier">
                                <option value="">--pilih supplier--</option>
                                @foreach($supplier as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="w-100">
                            <label for="no_nota" class="form-label">No. Nota</label>
                            <input type="text" class="form-control" id="no_nota" placeholder="No. Nota"
                                   name="no_nota">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="w-100">
                            <label for="tanggal" class="form-label">Tanggal Pembelian</label>
                            <input type="date" class="form-control" id="tanggal" value="{{ date('Y-m-d') }}"
                                   name="tanggal">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group w-100">
                    <label for="barang">Barang</label>
                    <select class="form-control" id="barang" name="barang">
                        <option value="">--pilih barang--</option>
                        @foreach($barang as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row p-0">
                    <div class="col-4">
                        <div class="w-100">
                            <label for="qty" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="qty" placeholder="Jumlah"
                                   name="qty" value="0">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="w-100">
                            <label for="harga" class="form-label">Harga (Rp.)</label>
                            <input type="number" class="form-control" id="harga" placeholder="Harga"
                                   name="harga" value="0">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="w-100">
                            <label for="total" class="form-label">Total (Rp.)</label>
                            <input type="number" class="form-control" id="total" placeholder="Total"
                                   name="total" value="0" readonly>
                        </div>
                    </div>
                </div>
                <div class="w-100 text-right mt-3">
                    <a href="#" class="btn btn-primary" id="btn-add"><i class="fa fa-plus mr-2"></i><span>Tambah</span></a>
                </div>
                <hr>
                <p class="font-weight-bold">Data Pembelian</p>
                <table id="table-data" class="display w-100 table table-bordered">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th>Barang</th>
                        <th width="15%" class="text-right">Harga (Rp.)</th>
                        <th width="15%" class="text-center">Jumlah</th>
                        <th width="15%" class="text-right">Total</th>
                        <th width="10%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var table;
        var path = '{{ route('pembelian.add') }}';

        function reload() {
            table.ajax.reload();
        }

        function calculateTotal() {
            let qty = $('#qty').val() !== '' ? $('#qty').val() : '0';
            let harga = $('#harga').val() !== '' ? $('#harga').val() : '0';
            let intQty = parseInt(qty);
            let intHarga = parseInt(harga);
            let total = (intQty * intHarga);
            $('#total').val(total);
        }

        function clear() {
            $('#barang').val('');
            $('#qty').val(0);
            $('#harga').val(0);
            $('#total').val(0);
        }

        function store() {
            let data = {
                barang: $('#barang').val(),
                qty: $('#qty').val(),
                harga: $('#harga').val(),
            };
            AjaxPost(path, data, function () {
                clear();
                SuccessAlert('Berhasil!', 'Berhasil menyimpan data...');
                reload();
            });
        }


        $(document).ready(function () {

            table = DataTableGenerator('#table-data', path, [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'barang.nama'},
                {
                    data: 'harga', name: 'harga', render: function (data) {
                        return data.toLocaleString('id-ID');
                    }
                },
                {
                    data: 'qty', name: 'qty', render: function (data) {
                        return data.toLocaleString('id-ID');
                    }
                },
                {
                    data: 'total', name: 'total', render: function (data) {
                        return data.toLocaleString('id-ID');
                    }
                },
                {
                    data: null, render: function (data) {
                        return '<a href="#" class="btn btn-sm btn-warning btn-edit mr-1" data-id="' + data['id'] + '" data-name="' + data['nama'] + '"><i class="fa fa-edit f12"></i></a>' +
                            '<a href="#" class="btn btn-sm btn-danger btn-delete" data-id="' + data['id'] + '"><i class="fa fa-trash f12"></i></a>';
                    }
                },
            ], [
                {
                    targets: [0, 3, 5],
                    className: 'text-center'
                },
                {
                    targets: [2, 4],
                    className: 'text-right'
                },
            ], function (d) {
            }, {
                "fnDrawCallback": function (setting) {
                }
            });

            $('#btn-add').on('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: "Konfirmasi!",
                    text: "Apakah anda yakin menambah data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.value) {
                        store();
                    }
                });
            });

            $('#qty').on('input', function () {
                calculateTotal();
            })
            $('#harga').on('input', function () {
                calculateTotal();
            })
        });
    </script>
@endsection
