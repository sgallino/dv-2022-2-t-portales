<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Genero
 *
 * @property int $genero_id
 * @property string $nombre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Genero newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Genero newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Genero query()
 * @method static \Illuminate\Database\Eloquent\Builder|Genero whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Genero whereGeneroId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Genero whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Genero whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Genero extends Model
{
//    use HasFactory;
    protected $table = "generos";
    protected $primaryKey = "genero_id";
}
