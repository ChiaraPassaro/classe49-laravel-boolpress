<?php

use Illuminate\Database\Seeder;
use App\Model\Post;
use App\Model\Tag;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::all();
        //ad ogni tag piu di un post
        foreach ($posts as $post) {
            $tags = Tag::inRandomOrder()->limit(3)->get();
            $post->tags()->attach($tags);
        }
    }
}
