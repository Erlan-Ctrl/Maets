<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JogosModel extends Model
{
    use HasFactory;

    protected $table = 'jogos';
    protected $fillable = ['titulo', 'descricao', 'preco', 'plataforma', 'cover', 'lancamento'];

    protected $casts = [
        'preco' => 'decimal:2',
        'lancamento' => 'date',
    ];

    public function getPrecoFormatadoAttribute(): string
    {
        return 'R$ ' . number_format((float)$this->preco, 2, ',', '.');
    }
}
