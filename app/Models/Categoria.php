<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Categoria
 *
 * @property int $categoria_id
 * @property string $nombre
 * @property string $abreviatura
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria query()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereCategoriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Categoria extends Model
{
//    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'categoria_id';
}
