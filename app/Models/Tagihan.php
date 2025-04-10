<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Dom\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tagihan extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    protected $guarded = [];
    protected $dates = ['tanggal_tagihan', 'tanggal_jatuh_tempo'];
    protected $with = ['user','siswa', 'tagihanDetails'];

    /**
     * Get the user that owns the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get thn siswa that owns the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

     /**
     * Get all of the tag for the Tagihan
     * 
     * @return \Illuminate\Database\Eloquent\Relations\Hasmany
     */
    public function tagihanDetails(): HasMany
    {
        return $this->hasMany(TagihanDetail::class);
    }

    

     /**
     * Get all of the pembayaran for the Tagihan
     * 
     * @return \Illuminate\Database\Eloquent\Relations\Hasmany
     */
    public function pembayaran(): HasMany
    {
        return $this->hasMany(pembayaran::class);
    }


    /**
     * The "booted" method of the model.
     * 
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($tagihan) {
            $tagihan->user_id = auth()->user()->id;
        });

        static::updating(function ($tagihan) {
            $tagihan->user_id = auth()->user()->id;
        });
    }

    public function formatRupiah($atribut)
    {
        return 'Rp ' . number_format($this->$atribut, 0, ',', '.');
    }
 
}