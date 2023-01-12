<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $student_id
 * @property string $attendance_id
 * @property string $status
 * @property string $cre_at
 * @property string $upd_at
 */
class StudentAttendence extends Model
{
    const CREATED_AT = 'cre_at';

    const UPDATED_AT = 'upd_at';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'student_attendances';

    /**
     * @var array
     */
    protected $fillable = ['status', 'cre_at', 'upd_at'];
}
