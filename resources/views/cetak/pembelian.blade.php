@extends('cetak.index')

@section('content')
    <div class="text-center report-title">LAPORAN PEMBELIAN</div>
    <div class="text-center text-body font-weight-bold">Periode {{ $tgl1 }} - {{ $tgl2 }}</div>
    <hr>
    <table id="my-table" class="table display" style="margin-top: 10px">
        <thead>
        <tr>
            <th width="5%" class="text-center text-body-small">#</th>
            <th width="8%" class="text-center text-body-small ">Tanggal</th>
            <th width="10%" class="text-center text-body-small">No. Nota</th>
            <th width="10%" class="text-center text-body-small">Supplier</th>
            <th class="text-body-small">Keterangan</th>
            <th width="9%" class="text-right text-body-small">Total (Rp.)</th>
            <th width="9%" class="text-right text-body-small">Terbayar (Rp.)</th>
            <th width="9%" class="text-right text-body-small">Sisa (Rp.)</th>
            <th width="7%" class="text-center text-body-small">Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $v)
            <tr>
                <td width="5%" class="text-center text-body-small">{{ $loop->index + 1 }}</td>
                <td class="text-center text-body-small">{{ $v->tanggal }}</td>
                <td class="text-center text-body-small">{{ $v->no_nota }}</td>
                <td class="text-body-small">{{ $v->supplier->nama }}</td>
                <td class="text-body-small">{{ $v->keterangan }}</td>
                <td class="text-right text-body-small">{{ number_format($v->total, 0, ',', '.') }}</td>
                <td class="text-right text-body-small">{{ number_format($v->terbayar, 0, ',', '.')}}</td>
                <td class="text-right text-body-small">{{ number_format($v->sisa, 0, ',', '.') }}</td>
                <td class="text-center text-body-small">
                    @if($v->sisa > 0)
                        <span>Hutang</span>
                    @else
                        <span>Lunas</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <hr>
    <div class="row">
        <div class="col-xs-9 f-bold text-body-small" style="text-align: right;">Total Pendapatan :</div>
        <div class="col-xs-2 f-bold text-body-small" style="text-align: right;">Rp. {{ number_format($data->sum('terbayar'), 0, ',', '.') }}</div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-8 f-bold report-header-sub-title" style="text-align: right;"></div>
        <div class="col-xs-3 f-bold text-body-small" style="text-align: center;">
            Surakarta, {{ \Carbon\Carbon::now()->format('d F Y') }}</div>
    </div>
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-xs-8 f-bold report-header-sub-title" style="text-align: right;"></div>
        <div class="col-xs-3 f-bold text-body-small" style="text-align: center;">(Admin)</div>
    </div>
@endsection
