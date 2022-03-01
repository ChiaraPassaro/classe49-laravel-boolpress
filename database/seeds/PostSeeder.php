<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Model\Post;
use App\User;


class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 30; $i++) {
            $newPost = new Post();
            $newPost->title = $faker->sentence(6, true);
            $newPost->content = $faker->paragraph(6, true);
            $title = "$newPost->title-$i";
            $newPost->slug = Str::slug($title, '-');
            $newPost->user_id = User::inRandomOrder()->first()->id;
            $newPost->save();
        }
    }
}
