<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Examen extends Model
{
    use HasFactory;

    protected $table = 'examens';

    protected $fillable = [
        'cod_etu',
        'module',
        'professeur',
        'semestre',
        'groupe',
        'date_examen',
        'horaire',
        'salle',
        'site',
    ];

    protected $casts = [
        'date_examen' => 'date',
        'horaire' => 'string',
    ];

    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class, 'cod_etu', 'cod_etu');
    }
}
