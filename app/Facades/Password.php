<?php

namespace App\Facades;
use Closure;
use Illuminate\Support\Facades\Password as ParentPassword;

use Illuminate\Contracts\Auth\PasswordBroker as PasswordBrokerContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Password extends ParentPassword {

    /**
     * Constant representing a successfully sent reminder.
     *
     * @var string
     */
    const FIRST_TIME_SETUP = 'passwords.first_time_setup';

    /**
     * Send a password reset link to a new user.
     *
     * @param  array  $credentials
     * @param  \Closure|null  $callback
     * @return string
     */
    
   // @cpnwaugha: c-e
    public function sendNewUserResetLink(array $credentials, Closure $callback = null, $view = null)
    {
        ParentPassword::sendResetLink($credentials, $callback, $view);
    }
}