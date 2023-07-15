<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranPiutang extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_piutang';

    protected $fillable = [
        'penjualan_id',
        'no_transaksi',
        'tanggal',
        'nominal',
        'keterangan'
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }
}
