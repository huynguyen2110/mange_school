<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $student_id
 * @property string $teacher_id
 * @property string $cre_at
 * @property string $upd_at
 */
class ClassStudent extends Model
{
    const CREATED_AT = 'cre_at';

    const UPDATED_AT = 'upd_at';
    /**
     * @var array
     */
    protected $fillable = ['cre_at', 'upd_at','student_id', 'teacher_id'];
}
