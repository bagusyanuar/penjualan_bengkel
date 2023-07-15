@extends('layout')

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Pembelian</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Pembelian
            </li>
        </ol>
    </div>
    <div class="w-100 p-2">
        <div class="card card-outline card-info">
            <div class="card-header">
                <div class="text-right mb-2">
                    <a href="{{ route('pembelian.add') }}" class="btn btn-primary btn-sm"><i
                            class="fa fa-plus mr-1"></i><span
                            class="font-weight-bold">Tambah</span></a>
                </div>
            </div>
            <div class="card-body">
                <table id="table-data" class="display w-100 table table-bordered" style="font-size: 12px;">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th width="8%" class="text-center">Tanggal</th>
                        <th width="10%" class="text-center">No. Nota</th>
                        <th width="10%">Supplier</th>
                        <th>Keterangan</th>
                        <th width="8%" class="text-right">Total (Rp.)</th>
                        <th width="8%" class="text-right">Terbayar (Rp.)</th>
                        <th width="8%" class="text-right">Hutang (Rp.)</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="5%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="modalInfoLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInfoLabel">Informasi Pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="w-100 mb-1">
                        <label for="supplier" class="form-label">Supplier</label>
                        <input type="text" class="form-control" id="supplier"
                               name="supplier" readonly>
                    </div>
                    <div class="row mb-1">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="no_nota" class="form-label">No. Nota</label>
                                <input type="text" class="form-control" id="no_nota"
                                       name="no_nota" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="text" class="form-control" id="tanggal"
                                       name="tanggal" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="w-100">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea rows="3" class="form-control" id="keterangan"
                                  name="keterangan" readonly></textarea>
                    </div>
                    <hr>
                    <table id="table-data-info" class="display table table-bordered" style="font-size: 12px;">
                        <thead>
                        <tr>
                            <th width="10%" class="text-center">#</th>
                            <th>Nama Barang</th>
                            <th width="15%" class="text-right">Harga (Rp.)</th>
                            <th width="15%" class="text-right">Jumlah</th>
                            <th width="15%" class="text-right">Total (Rp.)</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <hr>
                    <div class="row align-items-center mb-1">
                        <div class="col-8 text-right">
                            <span class="font-weight-bold">Sub Total :</span>
                        </div>
                        <div class="col-4">
                            <div class="w-100">
                                <input type="number" class="form-control text-right" id="sub_total"
                                       name="sub_total" value="0" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-8 text-right">
                            <span class="font-weight-bold">Diskon :</span>
                        </div>
                        <div class="col-4">
                            <div class="w-100">
                                <input type="number" class="form-control text-right" id="diskon"
                                       name="diskon" value="0" form="form-submit" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-8 text-right">
                            <span class="font-weight-bold">Total :</span>
                        </div>
                        <div class="col-4">
                            <div class="w-100">
                                <input type="number" class="form-control text-right" id="total-all"
                                       name="total-all" value="0" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-8 text-right">
                            <span class="font-weight-bold">Terbayar :</span>
                        </div>
                        <div class="col-4">
                            <div class="w-100">
                                <input type="number" class="form-control text-right" id="terbayar"
                                       name="terbayar" value="0" form="form-submit" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-1">
                        <div class="col-8 text-right">
                            <span class="font-weight-bold">Sisa :</span>
                        </div>
                        <div class="col-4">
                            <div class="w-100">
                                <input type="number" class="form-control text-right" id="sisa"
                                       name="sisa" value="0" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var table, tableInfo;
        var path = '{{ route('pembelian') }}';
        var dataSet = [];

        function reload() {
            table.ajax.reload();
        }

        function infoEvent() {
            $('.btn-info').on('click', async function (e) {
                e.preventDefault();
                try {
                    let id = this.dataset.id;
                    let url = path + '/' + id + '/info';
                    let response = await $.get(url);
                    let payload = response['payload'];
                    setInformation(payload);
                    console.log(response);
                    $('#modalInfo').modal('show');
                } catch (e) {
                    alert('terjadi kesalahan server');
                }

            })
        }

        function setInformation(p) {
            $('#supplier').val(p['supplier']['nama']);
            $('#no_nota').val(p['no_nota']);
            $('#tanggal').val(p['tanggal']);
            $('#sub_total').val(p['sub_total']);
            $('#diskon').val(p['diskon']);
            $('#total-all').val(p['total']);
            $('#terbayar').val(p['terbayar']);
            $('#keterangan').val(p['keterangan']);
            $('#sisa').val(p['sisa']);
            let tmpDataset = [];
            $.each(p['details'], function (k, v) {
                let nama = v['barang']['nama'];
                let harga = v['harga'].toLocaleString('id-ID');
                let qty = v['qty'].toLocaleString('id-ID');
                let total = v['total'].toLocaleString('id-ID');
                tmpDataset.push([(k + 1), nama, harga, qty, total])
            });
            dataSet = tmpDataset;
            tableInfo.clear().draw();
            tableInfo.rows.add(dataSet).draw();
        }

        $(document).ready(function () {
            table = DataTableGenerator('#table-data', path, [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'tanggal'},
                {data: 'no_nota'},
                {data: 'supplier.nama'},
                {data: 'keterangan'},
                {
                    data: 'total', name: 'total', render: function (data) {
                        return data.toLocaleString('id-ID');
                    }
                },
                {
                    data: 'terbayar', name: 'terbayar', render: function (data) {
                        return data.toLocaleString('id-ID');
                    }
                },
                {
                    data: 'sisa', name: 'sisa', render: function (data) {
                        return data.toLocaleString('id-ID');
                    }
                },
                {
                    data: 'sisa', name: 'sisa', render: function (data) {
                        if (data > 0) {
                            return '<div class="pl-3 pr-3 pt-1 pb-1" style="background-color: #c30101; color: whitesmoke; border-radius: 5px;">Hutang</div>'
                        }
                        return '<div class="pl-3 pr-3 pt-1 pb-1" style="background-color: #00a65a; color: whitesmoke; border-radius: 5px;">Lunas</div>';
                    }
                },
                {
                    data: null, render: function (data) {
                        return '<a href="#" class="btn btn-sm btn-primary btn-info" data-id="' + data['id'] + '"><i class="fa fa-info f12"></i></a>';
                    }
                },
            ], [
                {
                    targets: [0, 1, 2, 8, 9],
                    className: 'text-center'
                },
                {
                    targets: [5, 6, 7,],
                    className: 'text-right'
                },
            ], function (d) {
            }, {
                "fnDrawCallback": function (setting) {
                    infoEvent();
                }
            });

            tableInfo = $('#table-data-info').DataTable({
                data: dataSet,
                columnDefs: [
                    {
                        targets: [0, 3],
                        className: 'text-center'
                    },
                    {
                        targets: [2, 4],
                        className: 'text-right'
                    },
                ],
                ordering: false,
                dom: 't',
                pagination: false
            })
        });
    </script>
@endsection
