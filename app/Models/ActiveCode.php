<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;


use Jenssegers\Mongodb\Eloquent\Model;

class ActiveCode extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'active_code';

    protected $fillable = [
        'user_id',
        'code',
        'expired_at',
    ];

//    public $timestamps = false;
//    protected $dates = ['expired_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeVerifyCode($query , $code , $user )
    {

        return !! $user->activeCode()->whereCode($code)->where('expired_at' ,'>',now())->first();
    }

    public function scopeGenerateCode($query, $user)
    {

        if ($code = $this->getAliveCodeForUser($user)) {

            $code = $code->code;

        } else {
            do {
                $code = mt_rand(100000, 999999);
            } while ($this->checkCodeIsUnique($user, $code));
            $user->activeCode()->create([
                'code' => $code,
                'expired_at' => now()->addMinutes(10)->toIso8601ZuluString()
            ]);
        }
        return $code;

    }

    private function checkCodeIsUnique($user, $code)
    {
        return !! $user->activeCode()->whereCode($code)->first();
    }

    private function getAliveCodeForUser($user)
    {
        return $user->activeCode()->where('expired_at', '>', now())->first();
    }
}
