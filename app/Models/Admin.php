<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;

class Admin extends Authenticatable implements CanResetPasswordContract
{
    use CanResetPassword;
    protected $table = 't_admin';
    protected $primaryKey = 'nik_admin';
    public $timestamps = false;

    protected $fillable = [
        'nik_admin',
        'username',
        'nama',
        'email',
        'password',
        'foto',
    ];

    protected $hidden = ['password'];

    /**
     * Password di t_admin disimpan plaintext.
     * Override getAuthPassword agar framework
     * bisa tetap melakukan pengecekan via Auth::attempt.
     *
     * Kita TIDAK hash password di sini supaya cocok dgn data lama.
     */
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
            ->send(new \App\Mail\ResetPasswordMail($resetUrl, $this->nama));
    }
}
