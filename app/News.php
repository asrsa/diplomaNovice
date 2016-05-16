<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class News extends Model
{
    protected $table = 'news';

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function subcategory() {
        return $this->belongsTo('App\Subcategory');
    }

    public function comment() {
        return $this->hasMany('App\Comment');
    }


    public function getSubcategoryNewNews($catId) {
        $newNews = DB::table('subcategories')
            ->select('subcategories.name as subcategory', 'news.*')
            ->join('news', 'subcategories.id', '=', 'news.subcategory_id')
            ->where('subcategories.category_id', '=', $catId)
            ->orderBy('news.created_at', 'desc')
            ->take(5)
            ->get();

        return $newNews;
    }

    static function getSubcategoryId($catId) {
        $subId = DB::table('subcategories')
            ->select('id')
            ->where('category_id', '=', $catId)
            ->get();

        return $subId;
    }

    static function getSubcategoryNews($subcatId) {
        $news = DB::table('news')
            ->select('news.*', 'subcategories.desc as subcategory')
            ->join('subcategories', 'news.subcategory_id', '=', 'subcategories.id')
            ->where('news.subcategory_id', '=', $subcatId)
            ->orderBy('news.created_at', 'desc')
            ->take(3)
            ->get();

        return $news;
    }
}
