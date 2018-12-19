<?php

use Illuminate\Database\Seeder;

class RepliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $threads = \App\Thread::all();

        foreach ($threads as $thread) {
            factory(App\Reply::class, 10)->create([
                'thread_id' => $thread->id
            ]);
        }

    }
}
