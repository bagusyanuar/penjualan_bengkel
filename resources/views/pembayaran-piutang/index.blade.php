@extends('layout')

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Pembayaran Piutang</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Pembayaran Piutang
            </li>
        </ol>
    </div>
    <div class="w-100 p-2">
        <div class="card card-outline card-info">
            <div class="card-header">
                <div class="text-right mb-2">
                    <a href="{{ route('pembayaran-piutang.add') }}" class="btn btn-primary btn-sm"><i
                            class="fa fa-plus mr-1"></i><span
                            class="font-weight-bold">Tambah</span></a>
                </div>
            </div>
            <div class="card-body">
                <table id="table-data" class="display w-100 table table-bordered" style="font-size: 12px;">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th width="12%" class="text-center">Tanggal</th>
                        <th width="15%" class="text-center">No. Penjualan</th>
                        <th width="15%" class="text-center">No. Pembayaran</th>
                        <th width="15%">Customer</th>
                        <th>Keterangan</th>
                        <th width="12%" class="text-right">Nominal (Rp.)</th>
                        <th width="5%" class="text-center">Action</th>
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
        var path = '{{ route('pembayaran-piutang') }}';

        function reload() {
            table.ajax.reload();
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
        $(document).ready(function () {
            table = DataTableGenerator('#table-data', path, [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'tanggal'},
                {data: 'penjualan.no_nota'},
                {data: 'no_transaksi'},
                {data: 'penjualan.customer'},
                {data: 'keterangan'},
                {
                    data: 'nominal', name: 'nominal', render: function (data) {
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
                    targets: [0, 1, 2, 3, 4],
                    className: 'text-center'
                },
                {
                    targets: [6],
                    className: 'text-right'
                },
            ], function (d) {
            }, {
                "fnDrawCallback": function (setting) {
                    deleteEvent();
                }
            });
            deleteEvent();
        });
    </script>
@endsection
