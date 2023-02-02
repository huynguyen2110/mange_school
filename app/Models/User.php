<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string $uuid
 * @property string $name
 * @property string $course_id
 * @property string $major_id
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $birthday
 * @property string $year_of_admission
 * @property string $gender
 * @property string $phone
 * @property string $address
 * @property string $cre_at
 * @property string $upd_at
 */
class User extends Authenticatable
{

    const CREATED_AT = 'cre_at';

    const UPDATED_AT = 'upd_at';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['name', 'course_id', 'major_id', 'email', 'password', 'role', 'birthday', 'year_of_admission', 'gender', 'phone', 'address', 'cre_at', 'upd_at'];

    public function majors()
    {
        return $this->belongsTo(Major::class,'major_id','id');
    }

    public function courses()
    {
        return $this->belongsTo(Course::class,'course_id','id');
    }
}
