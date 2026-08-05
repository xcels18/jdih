<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegulationRelation extends Model
{
    protected $fillable = [
        'regulation_id', 'related_regulation_id', 'relation_type'
    ];

    public function regulation()
    {
        return $this->belongsTo(Regulation::class, 'regulation_id');
    }

    public function relatedRegulation()
    {
        return $this->belongsTo(Regulation::class, 'related_regulation_id');
    }
}
