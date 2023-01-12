<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $class_id
 * @property string $student_id
 * @property string $midterm_score
 * @property string $final_score
 * @property string $total
 * @property string $cre_at
 * @property string $upd_at
 */
class Score extends Model
{
    const CREATED_AT = 'cre_at';

    const UPDATED_AT = 'upd_at';
    /**
     * @var array
     */
    protected $fillable = ['student_id', 'class_id', 'midterm_score', 'final_score','total', 'cre_at', 'upd_at'];
}
