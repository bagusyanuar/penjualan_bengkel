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
    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Gagal!", '{{\Illuminate\Support\Facades\Session::get('failed')}}', "error")
        </script>
    @endif
    <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Tambah Pembayaran Hutang</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('pembayaran-hutang') }}">Pembayaran Hutang</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Pembayaran Hutang
            </li>
        </ol>
    </div>
    <div class="w-100 p-2">
        <div class="card card-outline card-info">
            <div class="card-header">
                <div class="text-left mb-2">
                    <p class="font-weight-bold">Form Tambah Pembayaran Hutang</p>
                </div>
            </div>
            <div class="card-body">
                <form method="post" id="form-submit">
                    @csrf
                    <div class="row">
                        <div class="col-6">
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
                        <div class="col-6">
                            <div class="w-100">
                                <label for="tanggal" class="form-label">Tanggal Pembayaran</label>
                                <input type="date" class="form-control" id="tanggal" value="{{ date('Y-m-d') }}"
                                       name="tanggal">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="w-100">
                                <label for="hutang" class="form-label">Hutang (Rp.)</label>
                                <input type="number" class="form-control" id="hutang"
                                       name="hutang" value="0" readonly>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="w-100">
                                <label for="pembayaran" class="form-label">Pembayaran (Rp.)</label>
                                <input type="number" class="form-control" id="pembayaran"
                                       name="pembayaran" value="0">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="w-100">
                                <label for="sisa" class="form-label">Sisa (Rp.)</label>
                                <input type="number" class="form-control" id="sisa"
                                       name="sisa" value="0" readonly>
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
                <div class="w-100 text-right mt-3">
                    <a href="#" class="btn btn-primary" id="btn-save"><i class="fa fa-save mr-2"></i><span>Simpan</span></a>
                </div>
                <hr>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var path = '{{ route('pembayaran-hutang.add') }}';

        async function getNilaiHutang() {
            try {
                let supplier = $('#supplier').val();
                let url = path + '?supplier='+supplier
                let response = await $.get(url);
                let payload = response['payload'];
                $('#hutang').val(payload);
                calculateSisa();
                console.log(response);
            }catch (e) {
                console.log(e);
                $('#hutang').val(0);
                $('#pembayaran').val(0);
                calculateSisa();
                alert(e);
            }
        }

        function calculateSisa() {
            let hutang = $('#hutang').val() !== '' ? $('#hutang').val() : '0';
            let bayar = $('#pembayaran').val() !== '' ? $('#pembayaran').val() : '0';
            let intHutang = parseInt(hutang);
            let intBayar = parseInt(bayar);
            let sisa = intHutang - intBayar;
            $('#sisa').val(sisa);
        }

        $(document).ready(function () {
            getNilaiHutang();
            $('#supplier').on('change', function () {
                if (this.value !== '') {
                    getNilaiHutang();
                }else {
                    $('#hutang').val(0);
                    $('#pembayaran').val(0);
                    $('#sisa').val(0);
                }

            });

            $('#pembayaran').on('input', function () {
                calculateSisa();
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
        });
    </script>
@endsection
