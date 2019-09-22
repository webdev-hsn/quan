<?php

use Illuminate\Database\Seeder;

class AnswerQuestionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('answers')->delete();
        \DB::table('questions')->delete();
        \DB::table('users')->delete();
        factory(App\User::class, 6)->create()->each(function($u){
            $u->questions()
            ->saveMany(
                factory(App\Question::class,rand(0,5))->make()
        )
            ->each(function($q){
            $q->answers()->saveMany(factory(App\Answer::class, rand(0,3))->make());
                });
            }
        );
    }
}
