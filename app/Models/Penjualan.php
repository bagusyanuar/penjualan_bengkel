<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $fillable = [
        'tanggal',
        'no_nota',
        'customer',
        'sub_total',
        'diskon',
        'total',
        'terbayar',
        'sisa',
        'keterangan'
    ];

    public function details()
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id');
    }

    public function getPelunasanAttribute()
    {
        return $this->hasMany(PembayaranPiutang::class, 'penjualan_id')->get()->sum('nominal');
    }

    public function getSisaPiutangAttribute()
    {
        return $this->sisa - $this->getPelunasanAttribute();
    }
}
