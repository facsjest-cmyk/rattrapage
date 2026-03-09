<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Etudiant extends Model
{
    use HasFactory;

    protected $table = 'etudiants';

    protected $primaryKey = 'cod_etu';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'cod_etu',
        'nom',
        'prenom',
        'date_naissance',
        'filiere',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    public function examens(): HasMany
    {
        return $this->hasMany(Examen::class, 'cod_etu', 'cod_etu');
    }
}
