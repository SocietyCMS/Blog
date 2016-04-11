<?php

namespace Modules\Blog\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\Factory\useFactories;
use Modules\Menu\Entities\Menu;

class DemoTableSeeder extends Seeder
{
    use useFactories;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('blog__articles')->delete();
        $this->factory(\Modules\Blog\Entities\Article::class, 12)
            ->create()
            ->each(function($article) {
                $faker = Factory::create();
                if($faker->boolean(60)) {
                    $image = $faker->image('/tmp', 1920, 1080);
                    $article->clearMediaCollection('cover');
                    $article->addMedia($image)->toMediaLibrary('cover');
                }

                $activity = $article->activities->first();
                $activity->update([
                    'created_at' => $start = $faker->dateTimeThisYear,
                    'updated_at' => $faker->dateTimeBetween($start),
                ]);
            });

        $this->createMenuEntry();
    }

    /**
     *
     */
    private function createMenuEntry()
    {
        if ($main = Menu::root()->where(['name' => 'Main'])->first()) {
            $main->children()->create(['name' => 'Blog', 'url' => 'blog', 'active' => true]);
        }
    }
}
