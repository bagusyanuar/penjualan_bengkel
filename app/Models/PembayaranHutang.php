<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranHutang extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_hutang';

    protected $fillable = [
        'supplier_id',
        'no_transaksi',
        'tanggal',
        'nominal',
        'keterangan',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
