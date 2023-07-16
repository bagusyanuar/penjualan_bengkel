<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';

    protected $fillable = [
        'nama',
        'no_hp',
        'alamat'
    ];

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'supplier_id');
    }

    public function pembayaran_hutang()
    {
        return $this->hasMany(PembayaranHutang::class, 'supplier_id');
    }

    public function getHutangAttribute()
    {
        $hutang = $this->pembelian()->where('sisa', '>', 0)->get()->sum('sisa');
        $terbayar = $this->pembayaran_hutang()->get()->sum('nominal');
        return $hutang - $terbayar;
    }
}
