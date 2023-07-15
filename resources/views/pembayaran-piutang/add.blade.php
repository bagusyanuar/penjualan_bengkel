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
        <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Tambah Pembayaran Piutang</p>
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('pembayaran-piutang') }}">Pembayaran Piutang</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Pembayaran Piutang
            </li>
        </ol>
    </div>
    <div class="w-100 p-2">
        <div class="card card-outline card-info">
            <div class="card-header">
                <div class="text-left mb-2">
                    <p class="font-weight-bold">Form Tambah Pembayaran Piutang</p>
                </div>
            </div>
            <div class="card-body">
                <form method="post" id="form-submit">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="penjualan">Nota Penjualan</label>
                                <select class="form-control" id="penjualan" name="penjualan">
                                    <option value="">--pilih nota penjualan--</option>
                                    @foreach($piutang as $p)
                                        <option value="{{ $p->id }}">{{ $p->no_nota }}</option>
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
                                <label for="piutang" class="form-label">Piutang (Rp.)</label>
                                <input type="number" class="form-control" id="piutang"
                                       name="piutang" value="0" readonly>
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
        var path = '{{ route('pembayaran-piutang.add') }}';

        async function getNilaiPiutang() {
            try {
                let penjualan = $('#penjualan').val();
                let url = path + '?penjualan='+penjualan;
                let response = await $.get(url);
                let payload = response['payload'];
                $('#piutang').val(payload);
                calculateSisa();
                console.log(response);
            }catch (e) {
                console.log(e);
                $('#piutang').val(0);
                $('#pembayaran').val(0);
                calculateSisa();
                alert(e);
            }
        }

        function calculateSisa() {
            let piutang = $('#piutang').val() !== '' ? $('#piutang').val() : '0';
            let bayar = $('#pembayaran').val() !== '' ? $('#pembayaran').val() : '0';
            let intPiutang = parseInt(piutang);
            let intBayar = parseInt(bayar);
            let sisa = intPiutang - intBayar;
            $('#sisa').val(sisa);
        }

        $(document).ready(function () {
            getNilaiPiutang();
            $('#penjualan').on('change', function () {
                if (this.value !== '') {
                    getNilaiPiutang();
                }else {
                    $('#piutang').val(0);
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
