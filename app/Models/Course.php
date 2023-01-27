<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $ministry_id
 * @property string $cre_at
 * @property string $upd_at
 */
class Course extends Model
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
    protected $fillable = ['name', 'founded_year', 'cre_at', 'upd_at'];
}
