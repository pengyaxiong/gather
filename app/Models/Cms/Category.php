<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Cache;
class Category extends Model
{
    protected $guarded = [];
    protected $table = 'article_categories';

    public function children()
    {
        return $this->hasMany('App\Models\Cms\Category', 'parent_id', 'id');
    }

    public function articles()
    {
        return $this->hasMany('App\Models\Cms\Article');
    }

    //清除缓存
    static function clear()
    {
        Cache::forget('cms_category_categories');
    }

    /**
     * 前端导航条
     * @return mixed
     */
    static function get_navigation()
    {
        $navigation = Cache::rememberForever('cms_index_navigation', function () {
            return self::with(['children' => function ($query) {
                $query->where('is_show', true)->orderBy('sort_order')->orderBy('id');
            }])
                ->where('is_show', true)->where("parent_id", 0)
                ->orderBy('sort_order')->orderBy('id')->get();
        });
        return $navigation;
    }


    /**
     * 生成分类数据
     * @return mixed
     */
    static function get_categories()
    {
        $categories = Cache::rememberForever('cms_category_categories', function () {
            $categories = self::orderBy('parent_id')->orderBy('sort_order')->orderBy('id')->get();
            return tree($categories);
        });
        return $categories;
    }


    /**
     * 检查是否有子栏目
     */
    static function check_children($id)
    {
        $category = self::with('children')->find($id);
        if ($category->children->isEmpty()) {
            return true;
        }
        return false;
    }

    /**
     * 检查是否有文章
     */
    static function check_articles($id)
    {
        $category = self::with('articles')->find($id);
        if ($category->articles->isEmpty()) {
            return true;
        }
        return false;
    }
}
