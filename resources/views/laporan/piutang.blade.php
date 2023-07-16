@extends('layout')

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Laporan Piutang</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Piutang
            </li>
        </ol>
    </div>
    <div class="w-100 p-2">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                   aria-selected="true">Piutang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                   aria-controls="profile" aria-selected="false">Pembayaran</a>
            </li>

        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <p class="font-weight-bold mb-0">Data Piutang Ke Customer</p>
                            <div class="text-right">
                                <a href="#" class="btn btn-success" id="btn-cetak-penjualan">
                                    <i class="fa fa-print mr-2"></i>
                                    <span>Cetak</span>
                                </a>
                            </div>
                        </div>

                        <hr>
                        <table id="table-data-penjualan" class="display w-100 table table-bordered"
                               style="font-size: 12px;">
                            <thead>
                            <tr>
                                <th width="5%" class="text-center">#</th>
                                <th width="20%">Nota Penjualan</th>
                                <th>Customer</th>
                                <th width="15%" class="text-right">Piutang (Rp.)</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <hr>
                        <div class="text-right mt-3">
                            <span class="mr-2 font-weight-bold">Total Piutang : </span>
                            <span class="font-weight-bold" id="lbl-total-piutang">Rp. 0</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <div class="card-body">
                            <p class="font-weight-bold mb-0">Filter Tanggal</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center w-50">
                                    <input type="date" class="form-control" name="tgl1" id="tgl1"
                                           value="{{ date('Y-m-d') }}">
                                    <span class="font-weight-bold mr-2 ml-2">S/D</span>
                                    <input type="date" class="form-control" name="tgl2" id="tgl2"
                                           value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="text-right">
                                    <a href="#" class="btn btn-success" id="btn-cetak-pembayaran">
                                        <i class="fa fa-print mr-2"></i>
                                        <span>Cetak</span>
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <table id="table-data" class="display w-100 table table-bordered" style="font-size: 12px;">
                                <thead>
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th width="8%" class="text-center">Tanggal</th>
                                    <th width="10%" class="text-center">No. Pembayaran</th>
                                    <th width="10%">Nota Penjualan</th>
                                    <th width="15%">Customer</th>
                                    <th>Keterangan</th>
                                    <th width="12%" class="text-right">Nominal (Rp.)</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="text-right mt-3">
                                <span class="mr-2 font-weight-bold">Total Pembayaran Piutang : </span>
                                <span class="font-weight-bold" id="lbl-total-pembayaran">Rp. 0</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var table, tablePenjualan;
        var path = '{{ route('laporan.piutang') }}';
        var dataSet = [];

        function reload() {
            table.ajax.reload();
        }

        function reloadPenjualan() {
            tablePenjualan.ajax.reload();
        }

        $(document).ready(function () {
            tablePenjualan = DataTableGenerator('#table-data-penjualan', path + '?type=penjualan', [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'no_nota'},
                {data: 'customer'},
                {
                    data: 'sisa_piutang', name: 'sisa_piutang', render: function (data) {
                        return data.toLocaleString('id-ID');
                    }
                },
            ], [
                {
                    targets: [0],
                    className: 'text-center'
                },
                {
                    targets: [3],
                    className: 'text-right'
                },
            ], function (d) {

            }, {
                dom: 'ltipr',
                "fnDrawCallback": function (setting) {
                    // infoEvent();
                    let data = this.fnGetData();
                    let total = data.map(item => item['sisa_piutang']).reduce((prev, next) => prev + next, 0);
                    $('#lbl-total-piutang').html('Rp. ' + total.toLocaleString('id-ID'));
                }
            });

            table = DataTableGenerator('#table-data', path, [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'tanggal'},
                {data: 'no_transaksi'},
                {data: 'penjualan.no_nota'},
                {data: 'penjualan.customer'},
                {data: 'keterangan'},
                {
                    data: 'nominal', name: 'total', render: function (data) {
                        return data.toLocaleString('id-ID');
                    }
                },
            ], [
                {
                    targets: [0, 1, 2, 3],
                    className: 'text-center'
                },
                {
                    targets: [6],
                    className: 'text-right'
                },
            ], function (d) {
                d.tgl1 = $('#tgl1').val();
                d.tgl2 = $('#tgl2').val();
            }, {
                dom: 'ltipr',
                "fnDrawCallback": function (setting) {
                    // infoEvent();
                    let data = this.fnGetData();
                    let total = data.map(item => item['nominal']).reduce((prev, next) => prev + next, 0);
                    $('#lbl-total-pembayaran').html('Rp. ' + total.toLocaleString('id-ID'));
                }
            });

            $('#tgl1').on('change', function (e) {
                reload();
            });
            $('#tgl2').on('change', function (e) {
                reload();
            });

            $('#btn-cetak-penjualan').on('click', function (e) {
                e.preventDefault();
                window.open('/laporan/piutang/cetak?type=penjualan', '_blank');
            });

            $('#btn-cetak-pembayaran').on('click', function (e) {
                e.preventDefault();
                let tgl1 = $('#tgl1').val();
                let tgl2 = $('#tgl2').val();
                window.open('/laporan/piutang/cetak?type=pembayaran&tgl1=' + tgl1 + '&tgl2=' + tgl2, '_blank');
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

                console.log(e.target.id) // newly activated tab
                e.relatedTarget // previous active tab
                if (e.target.id === 'profile-tab') {
                    table.columns.adjust().draw();
                } else {
                    tableSupplier.columns.adjust().draw();
                }
            })
        });
    </script>
@endsection
