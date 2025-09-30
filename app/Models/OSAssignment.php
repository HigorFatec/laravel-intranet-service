<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OSAssignment extends Model
{
    protected $table = 'os_assignments'; // Nome da tabela, se diferente do padrão
    protected $connection = 'mysql';

    protected $fillable = [
        'matricula',
        'os_id',
        'codire', // 👈 Novo campo
        'start_time',
        'pause_time',
        'resume_time',
        'finish_time',
    ];

    // Método custom para filtrar
    public static function getByMatriculaAndOsId($matricula, $osId)
    {
        return self::where('matricula', $matricula)
                   ->where('os_id', $osId)
                   ->first();
    }

        // ✅ RELACIONAMENTO: Um assignment tem muitas pausas
    public function pauses()
    {
        return $this->hasMany(OSPause::class, 'assignment_id');
    }
}
