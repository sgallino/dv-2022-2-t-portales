<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pais
 *
 * @property int $pais_id
 * @property string $nombre
 * @property string $abreviatura Por ejemplo: ARG, BRA, etc
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Pais newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pais newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pais query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pais whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pais whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pais whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pais wherePaisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pais whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pais extends Model
{
//    use HasFactory;

    protected $table = "paises";
    protected $primaryKey = "pais_id";
}
