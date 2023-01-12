<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $class_id
 * @property string $date
 * @property string $shift
 * @property string $cre_at
 * @property string $upd_at
 */
class Attendence extends Model
{
    const CREATED_AT = 'cre_at';

    const UPDATED_AT = 'upd_at';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attendances';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['class_id', 'date', 'shift', 'cre_at', 'upd_at'];
}
