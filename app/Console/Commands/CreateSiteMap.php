<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use App\Models\PcmDmsCategory;
use App\Models\Article;

class CreateSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create site map';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //create new sitemap object
        $sitemap = App::make("sitemap");
        //add items to the sitemap (url, date, priority, freq)
        $sitemap->add(route('front.home'), Carbon::now(), 1, 'daily');
        $sitemap->add(route('download.list'), Carbon::now(), 1, 'daily');

        $categories = (new PcmDmsCategory())->getListCategory(true, true)->get();

        foreach ($categories as $category)
        {
            $sitemap->add(route('home.category.show', $category->id), $category->updated_at, 1, 'daily');
            if (count($category->childs) > 0) {
                $this->subCategory($sitemap, $category->childs);
            }
        }

        foreach(Article::LIST_ARTICLES as $article) {
            $sitemap->add(route('home.article.detail', $article['slug']), Carbon::now(), 1, 'daily');
        }

        //generate your sitemap (format, filename)
        $sitemap->store('xml', 'sitemap');
    }

    public function subCategory($sitemap, $subCategory) {
        foreach ($subCategory as $category)
        {
            $sitemap->add(route('home.category.show', $category->id), $category->updated_at, 1, 'daily');
            if (count($category->childs) > 0) {
                $this->subCategory($sitemap, $category->childs);
            }
        }
    }
}
