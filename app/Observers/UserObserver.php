<?php

namespace App\Observers;
use Illuminate\Support\Facades\Session;
use App\Mail\UserCreatedEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
class UserObserver
{
    public function created(User $user){
        Mail::to($user->email)->send(new UserCreatedEmail($user['name'],$user['admin_code'],Session::get('password')));
        Session::forget('password');
    }
}
