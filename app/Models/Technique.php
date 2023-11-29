<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technique extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'techniques';

    protected $fillable = ['nombre','slug'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function currentQuotes()
    {
        return $this->hasMany('App\Models\CurrentQuote', 'technique_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materialTechniques()
    {
        return $this->hasMany('App\Models\MaterialTechnique', 'technique_id', 'id');
    }
    
}
