<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialTechnique extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'material_technique';

    protected $fillable = ['technique_id', 'material_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function material()
    {
        return $this->hasOne('App\Models\Material', 'id', 'material_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sizeMaterialTechniques()
    {
        return $this->belongsToMany('App\Models\Size', 'size_material_technique', 'material_technique_id', 'size_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function technique()
    {
        return $this->hasOne('App\Models\Technique', 'id', 'technique_id');
    }
}
