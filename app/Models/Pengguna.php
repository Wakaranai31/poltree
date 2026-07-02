<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;

class Pengguna extends Authenticatable implements CanResetPasswordContract
{
    use CanResetPassword;
    protected $table = 't_pengguna';

    protected $primaryKey = 'nik';

    public $timestamps = false;

    protected $fillable = [
        'nik',
        'username',
        'nama_user',
        'password',
        'email',
        'jabatan',
        'foto',
    ];

    protected $hidden = ['password'];

    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Override fungsi bawaan Laravel untuk mengirim email reset password
     * dengan Mailable custom milik sistem.
     */
    public function sendPasswordResetNotification($token)
    {
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $this->email]);
        \Illuminate\Support\Facades\Mail::to($this->email)
            ->send(new \App\Mail\ResetPasswordMail($resetUrl, $this->nama_user));
    }
}
