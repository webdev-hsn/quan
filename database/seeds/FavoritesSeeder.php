<?php

use Illuminate\Database\Seeder;
use App\Question;
use App\User;

class FavoritesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('favorites')->delete();
        $users = User::pluck('id')->all();
        $usersCount = count($users);

        foreach(Question::all() as $question){

            for($i=0; $i < rand(0, $usersCount);$i++){
                $user = $users[$i];
                $question->favorites()->attach($user);
            }
        }

    }
}
