<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname', 'password','avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function indents()
    {
        return $this->hasMany(Ident::class,'user_id');
    }


    /**
     * @param $identify
     * @param $password
     * @return User|Builder|\Illuminate\Database\Eloquent\Model|object|null
     * @throws @\Throwable
     */
    public function getUserByIdentifyPassword($identify,$password)
    {
        $user = static::whereHas('indents', function (Builder $query) use($identify){
            $query->where('identify', $identify);
        })->first();
        return $user;
    }

    /**
     * @param $identify
     * @return User|Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getUserByIdentify($identify)
    {
        return static::whereHas('indents', function (Builder $query) use($identify){
            $query->where('identify', $identify);
        })->first();
    }

    /**
     * @param $user_data
     * @param $indent_data
     * @return User|\Illuminate\Database\Eloquent\Model
     * @throws @\Throwable
     */
    public function createUser($user_data, $indent_data)
    {
        $user = static::create($user_data);
        throw_unless($user,\Exception::class,['����ʧ��']);
        $indent_data['user_id']=$user->id;
        $user->indents()->create($indent_data);
        return $user;
    }
}
