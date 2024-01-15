<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $usersIDs = DB::table('users')->pluck('id');
        $commentsIDs = DB::table('comments')->pluck('id');
        $postsIDs = DB::table('posts')->pluck('id');
        DB::table('comments')->insert([
            'user_id' => $usersIDs->random(),
            'post_id' => $postsIDs->random(),
            'parent_id'=>$commentsIDs->random(),
            'content' => Str::random(200),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
}
