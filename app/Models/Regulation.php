<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regulation extends Model
{
    protected $fillable = [
        'type', 'number', 'year', 'title', 'stipulation_date', 'status', 'description', 'file_path', 'teu', 'law_field', 'subject',
        'document_type', 'publishing_place', 'promulgation_date', 'gov_affairs', 'view_count', 'download_count', 'external_pdf_url'
    ];

    protected $casts = [
        'stipulation_date' => 'date',
        'promulgation_date' => 'date',
    ];

    public function relations()
    {
        return $this->hasMany(RegulationRelation::class, 'regulation_id');
    }

    public function relatedTo()
    {
        return $this->hasMany(RegulationRelation::class, 'related_regulation_id');
    }
}
