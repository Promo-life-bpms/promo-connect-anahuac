<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricesTechnique extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'prices_techniques';

    protected $fillable = ['size_material_technique_id', 'escala_inicial', 'escala_final', 'precio', 'tipo_precio'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sizeMaterialTechnique()
    {
        return $this->hasOne('App\Models\SizeMaterialTechnique', 'id', 'size_material_technique_id');
    }
}
