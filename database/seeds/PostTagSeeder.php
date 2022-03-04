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
        $tags = Tag::all();
        //ad ogni tag piu di un post
        foreach ($tags as $tag) {
            $posts = Post::inRandomOrder()->limit(6)->get();
            $tag->posts()->attach($posts);
        }
    }
}
