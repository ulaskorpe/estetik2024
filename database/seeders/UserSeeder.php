<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->email= 'ulaskorpe@gmail.com';
        $user->admin_code= 169406;
        $user->name= 'ulaş körpe';
        $user->phone_number= '5066063000';
       $user->password= Hash::make('123123');
       $user->save();

       User::factory(10)->create();
    }
}
