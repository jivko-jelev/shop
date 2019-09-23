<?php

use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('first_name', 30)->nullable();
            $table->string('last_name', 30)->nullable();
            $table->enum('sex', ['Мъж', 'Жена'])->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->rememberToken();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
        });

        User::insert([
            'name' => 'admin',
            'first_name' => 'Джон',
            'last_name' => 'Доу',
            'sex' => 1,
            'email' => 'admin@domain.com',
            'password' => bcrypt('complexpassword123'),
            'is_admin' => true,
        ]);
        User::insert([
            'name' => 'givko',
            'first_name' => 'Живко',
            'last_name' => 'Желев',
            'sex' => 1,
            'email' => 'givko@domain.com',
            'password' => bcrypt('complexpassword123'),
            'is_admin' => false,
        ]);
        User::insert([
            'name' => 'john',
            'first_name' => 'Джон',
            'sex' => 1,
            'email' => 'john@abv.bg',
            'password' => bcrypt('complexpassword123'),
            'is_admin' => false,
        ]);
        User::insert([
            'name' => 'jane',
            'first_name' => 'Джейн',
            'last_name' => 'Доу',
            'sex' => 2,
            'email' => 'jane@domain.com',
            'password' => bcrypt('complexpassword123'),
        ]);
        User::insert([
            'name' => 'geri',
            'first_name' => 'Гергана',
            'last_name' => 'Иванова',
            'email' => 'geri@gmail.com',
            'password' => bcrypt('complexpassword123'),
        ]);
        User::insert([
            'name' => 'dimo',
            'first_name' => 'Димо',
            'sex' => 1,
            'email' => 'dimo@abv.bg',
            'password' => bcrypt('complexpassword123'),
            'is_admin' => false,
        ]);
        User::insert([
            'name' => 'petar',
            'first_name' => 'Петър',
            'last_name' => 'Вълев',
            'sex' => 1,
            'email' => 'petar@domain.com',
            'password' => bcrypt('complexpassword123'),
        ]);
        User::insert([
            'name' => 'iliana',
            'first_name' => 'Илияна',
            'last_name' => 'Димова',
            'sex' => 2,
            'email' => 'iliana@domain.com',
            'password' => bcrypt('complexpassword123'),
        ]);
        User::insert([
            'name' => 'georgi',
            'first_name' => 'Георги',
            'last_name' => 'Николов',
            'sex' => 1,
            'email' => 'georgi@abv.bg',
            'password' => bcrypt('complexpassword123'),
        ]);
        User::insert([
            'name' => 'neo',
            'first_name' => 'Нео',
            'sex' => 1,
            'email' => 'neo@matrix.com',
            'password' => bcrypt('complexpassword123'),
            'is_admin' => true,
        ]);
        User::insert([
            'name' => 'trinity',
            'first_name' => 'Тринити',
            'sex' => 2,
            'email' => 'trinity@matrix.com',
            'password' => bcrypt('complexpassword123'),
        ]);
        User::insert([
            'name' => 'morpheus',
            'first_name' => 'Морфей',
            'sex' => 1,
            'email' => 'morpeus@matrix.com',
            'password' => bcrypt('complexpassword123'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
