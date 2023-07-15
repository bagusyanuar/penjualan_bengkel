@extends('layout')

@section('css')
    <style>
        .swal2-shown {
            overflow: unset !important;
            padding-right: 0 !important;
        }
    </style>
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Gagal!", '{{\Illuminate\Support\Facades\Session::get('failed')}}', "error")
        </script>
    @endif
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Tambah Penjualan</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('penjualan') }}">Penjualan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Penjualan
            </li>
        </ol>
    </div>
    <div class="w-100 p-2">
        <div class="card card-outline card-info">
            <div class="card-header">
                <div class="text-left mb-2">
                    <p class="font-weight-bold">Form Tambah Penjualan</p>
                </div>
            </div>
            <div class="card-body">
                <form method="post" id="form-submit">
                    @csrf
                    <div class="row">
                        <div class="col-5">
                            <div class="w-100">
                                <label for="customer" class="form-label">Customer</label>
                                <input type="text" class="form-control" id="customer" placeholder="Customer"
                                       name="customer">
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
                    <div class="w-100">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea rows="3" class="form-control" id="keterangan"
                                  name="keterangan"></textarea>
                    </div>
                </form>
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
                                   name="harga" value="0" readonly>
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
                        <th width="15%" class="text-right">Total (Rp.)</th>
                        <th width="10%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <hr>
                <div class="row align-items-center mb-1">
                    <div class="col-9 text-right">
                        <span class="font-weight-bold">Sub Total :</span>
                    </div>
                    <div class="col-3">
                        <div class="w-100">
                            <input type="number" class="form-control text-right" id="sub_total"
                                   name="sub_total" value="0" readonly>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-1">
                    <div class="col-9 text-right">
                        <span class="font-weight-bold">Diskon :</span>
                    </div>
                    <div class="col-3">
                        <div class="w-100">
                            <input type="number" class="form-control text-right" id="diskon"
                                   name="diskon" value="0" form="form-submit">
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-1">
                    <div class="col-9 text-right">
                        <span class="font-weight-bold">Total :</span>
                    </div>
                    <div class="col-3">
                        <div class="w-100">
                            <input type="number" class="form-control text-right" id="total-all"
                                   name="total-all" value="0" readonly>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-1">
                    <div class="col-9 text-right">
                        <span class="font-weight-bold">Terbayar :</span>
                    </div>
                    <div class="col-3">
                        <div class="w-100">
                            <input type="number" class="form-control text-right" id="terbayar"
                                   name="terbayar" value="0" form="form-submit">
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-1">
                    <div class="col-9 text-right">
                        <span class="font-weight-bold">Sisa :</span>
                    </div>
                    <div class="col-3">
                        <div class="w-100">
                            <input type="number" class="form-control text-right" id="sisa"
                                   name="sisa" value="0">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="w-100 text-right">
                    <a href="#" class="btn btn-primary" id="btn-save"><i class="fa fa-send mr-2"></i><span>Simpan</span></a>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var table;
        var path = '{{ route('penjualan.add') }}';

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

        function calculateSisa() {
            let subTotal = $('#sub_total').val() !== '' ? $('#sub_total').val() : '0';
            let diskon = $('#diskon').val() !== '' ? $('#diskon').val() : '0';
            let terbayar = $('#terbayar').val() !== '' ? $('#terbayar').val() : '0';
            let intSubTotal = parseInt(subTotal);
            let intDiskon = parseInt(diskon);
            let intTerbayar = parseInt(terbayar);
            let totalAll = intSubTotal - intDiskon;
            let sisa = totalAll - intTerbayar;
            $('#total-all').val(totalAll);
            $('#sisa').val(sisa);
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

        function destroy(id) {
            let url = path + '/' + id + '/delete';
            AjaxPost(url, {}, function () {
                SuccessAlert('Berhasil!', 'Berhasil menghapus data...');
                reload();
            });
        }

        function deleteEvent() {
            $('.btn-delete').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                Swal.fire({
                    title: "Konfirmasi!",
                    text: "Apakah anda yakin menghapus data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.value) {
                        destroy(id);
                    }
                });

            })
        }

        function barangChangeEvent() {
            $('#barang').on('change', function (e) {
                e.preventDefault();
                barangChangeHandler();
            })
        }

        async function barangChangeHandler() {
            let id = $('#barang').val();
            if (id !== '') {
                try {
                    let url = path + '/' + id + '/barang';
                    let response = await $.get(url);
                    let payload = response['payload'];
                    let qty = $('#qty').val() !== '' ? $('#qty').val() : '0';
                    let intQty = parseInt(qty);
                    if (payload != null) {
                        let harga = payload['harga'];
                        let total = intQty * harga;
                        $('#harga').val(harga);
                        $('#total').val(total);
                    }else {
                        $('#harga').val(0);
                        $('#total').val(0);
                    }
                } catch (e) {
                    $('#harga').val(0);
                    $('#total').val(0);
                    alert('terjadi kesalahan server');
                }
            } else {
                $('#harga').val(0);
                $('#total').val(0);
            }

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
                        return '<a href="#" class="btn btn-sm btn-danger btn-delete" data-id="' + data['id'] + '"><i class="fa fa-trash f12"></i></a>';
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
                    let data = this.fnGetData();
                    let total = data.map(item => item['total']).reduce((prev, next) => prev + next, 0);
                    $('#sub_total').val(total);
                    calculateSisa();
                    deleteEvent();
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

            $('#btn-save').on('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: "Konfirmasi!",
                    text: "Apakah anda yakin meyimpan data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.value) {
                        $('#form-submit').submit();
                    }
                });
            });

            deleteEvent();
            $('#qty').on('input', function () {
                calculateTotal();
            });

            $('#harga').on('input', function () {
                calculateTotal();
            });

            $('#diskon').on('input', function () {
                calculateSisa();
            });

            $('#terbayar').on('input', function () {
                calculateSisa();
            });

            barangChangeHandler();
            barangChangeEvent();
        });
    </script>
@endsection
