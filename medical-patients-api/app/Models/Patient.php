<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document', 'first_name', 'last_name', 'birth_date', 'email', 'phone', 'genre'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];


    /**
     * The diagnostics that belong to the Patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function diagnostics()
    {
        return $this->belongsToMany(Diagnostic::class, 'patient_diagnostics')->withTimestamps()->withPivot('observation');
    }



    /**
     * Format diagnostics to include only the desired fields and adjust the date format in the pivot table.
     */
    public function formatDiagnostics()
    {
        $this->diagnostics->transform(function ($diagnostic) {
            return [
                'id'          => $diagnostic->id,
                'name'        => $diagnostic->name,
                'description' => $diagnostic->description,
                'observation' => $diagnostic->pivot->observation,
                'creation'    => $diagnostic->pivot->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    /**
     * Override the default Eloquent toArray method to automatically format diagnostics.
     *
     * @return array
     */
    public function toArray()
    {
        $this->formatDiagnostics();
        return parent::toArray();
    }
}
