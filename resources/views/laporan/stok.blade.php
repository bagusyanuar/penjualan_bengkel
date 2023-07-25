@extends('layout')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Laporan Stok</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Laporan Stok
            </li>
        </ol>
    </div>
    <div class="w-100 p-2">
        <div class="card card-outline card-info">
            <div class="card-header">
                {{--                <p class="font-weight-bold mb-0">Filter Tanggal</p>--}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center w-50">
                        {{--                        <input type="date" class="form-control" name="tgl1" id="tgl1" value="{{ date('Y-m-d') }}">--}}
                        {{--                        <span class="font-weight-bold mr-2 ml-2">S/D</span>--}}
                        {{--                        <input type="date" class="form-control" name="tgl2" id="tgl2" value="{{ date('Y-m-d') }}">--}}
                    </div>
                    <div class="text-right">
                        <a href="#" target="_blank" class="btn btn-success" id="btn-cetak">
                            <i class="fa fa-print mr-2"></i>
                            <span>Cetak</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="table-data" class="display w-100 table table-bordered">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th width="17%">Kategori Barang</th>
                        <th>Nama</th>
                        <th width="12%">Qty</th>
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

        function reload() {
            table.ajax.reload();
        }

        $(document).ready(function () {
            table = DataTableGenerator('#table-data', '{{ route('laporan.stok') }}', [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'kategori.nama'},
                {data: 'nama'},
                {data: 'qty'},
            ], [
                {
                    targets: [0,1, 3],
                    className: 'text-center'
                },
            ], function (d) {
            }, {
                "fnDrawCallback": function (setting) {
                }
            });

            $('#btn-cetak').on('click', function (e) {
                e.preventDefault();
                window.open('/laporan/stok/cetak', '_blank');
            });
        });
    </script>
@endsection
