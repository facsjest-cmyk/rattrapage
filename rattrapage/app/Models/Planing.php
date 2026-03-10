<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planing extends Model
{
    use HasFactory;

    protected $table = 'planing';

    protected $fillable = [
        'cod_etu',
        'lib_nom_pat_ind',
        'date_nai_ind',
        'lib_pr1_ind',
        'cod_elp',
        'filiere',
        'cod_tre',
        'cod_ext_gpe',
        'mod_groupe',
        'prof',
        'module',
        'salle',
        'num_exam',
        'site',
        'date',
        'horaire',
        'present',
    ];

    protected $casts = [
        'date_nai_ind' => 'date',
        'date' => 'date',
        'horaire' => 'string',
        'present' => 'boolean',
    ];

    public function getNomAttribute(): ?string
    {
        return $this->lib_nom_pat_ind;
    }

    public function getPrenomAttribute(): ?string
    {
        return $this->lib_pr1_ind;
    }

    public function getDateNaissanceAttribute()
    {
        return $this->date_nai_ind;
    }

    public function getDateExamenAttribute()
    {
        return $this->date;
    }

    public function getProfesseurAttribute(): ?string
    {
        return $this->prof;
    }

    public function getSemestreAttribute(): ?string
    {
        $code = $this->cod_elp;

        if ($code === null) {
            return null;
        }

        $code = (string) $code;

        if (strlen($code) >= 5) {
            return substr($code, 4, 1);
        }

        return $code;
    }

    public function getGroupeAttribute(): ?string
    {
        return $this->cod_ext_gpe;
    }
}
