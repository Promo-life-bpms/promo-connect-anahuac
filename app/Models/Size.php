<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'sizes';

    protected $fillable = ['nombre','slug'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sizeMaterialTechniques()
    {
        return $this->hasMany('App\Models\SizeMaterialTechnique', 'size_id', 'id');
    }
    
}
