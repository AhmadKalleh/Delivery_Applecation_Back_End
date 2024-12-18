<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $image_path
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_number
 * @property string $email
 * @property string $password
 * @property string $verfication_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PendingUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PendingUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PendingUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|PendingUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendingUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendingUser whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendingUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendingUser whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendingUser whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendingUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendingUser wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendingUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendingUser whereVerficationCode($value)
 * @mixin \Eloquent
 */
class PendingUser extends Model
{
    use HasFactory;

    protected $fillable = ['image_path','first_name', 'last_name', 'email', 'password', 'phone_number', 'verfication_code'];
}
