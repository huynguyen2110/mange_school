<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $subject_id
 * @property string $teacher_id
 * @property string $cre_at
 * @property string $upd_at
 */
class Classes extends Model
{
    const CREATED_AT = 'cre_at';

    const UPDATED_AT = 'upd_at';
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['name', 'subject_id', 'teacher_id', 'cre_at', 'upd_at'];

    public function teachers()
    {
        return $this->belongsTo(User::class,'teacher_id','uuid');
    }

    public function subjects()
    {
        return $this->belongsTo(Subject::class,'subject_id','id');
    }
}
