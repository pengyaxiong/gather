<?php

namespace App\Models\Cms;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;

class Customer extends Authenticatable
{
    use Notifiable,LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone','password', 'api_token','age','name','qq','email','api_token','sex','state','city','address','money'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    //黑名单
    protected $guarded = [''];

    /**
     * 用户图像
     */
//    public function avatar()
//    {
//        $photo = self::with('photo')->find($this->id)->photo;
//        $avatar = $photo ? $photo->identifier : Gravatar::src($this->email, 200);
//        return $avatar;
//    }


}
