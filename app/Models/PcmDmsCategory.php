<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PcmDmsCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pcm_dms_categories';
    const MAIN_FLAG_ON = 1;
    const MAIN_FLAG_OFF = 0;
    const TREE_FLAG_ON = 1;
    const TREE_FLAG_OFF = 0;
    const GENRE_TOP_FLAG_ON = 1;
    const GENRE_TOP_FLAG_OFF = 0;
    const FOLDER_IMAGE = 'categories';
    const PUBLISHED_OFF = 0;
    const PUBLISHED_ON = 1;
    const IS_NOT_FORUM = 0;
    const IS_FORUM = 1;
    const IS_MENU_ON = 1;
    const IS_MENU_OFF = 0;
    const LIST = 1;
    const GRID = 0;
    const LAYOUT = [
        self::LIST => 'List',
        self::GRID => 'Grid'
    ];

    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'description',
        'category_thumb',
        'meta_key',
        'meta_description',
        'ordering',
        'is_menu',
        'layout_type',
        'published',
    ];

    public function childs()
    {
        return $this->hasMany('App\Models\PcmDmsCategory', 'parent_id', 'id')->orderBy('ordering');
    }

    public function documents()
    {
        return $this->belongsToMany(PcmDmsDocument::class, 'pcm_dms_category_documents', 'category_id', 'document_id');
    }

    public function getListCategory($parent = false)
    {
        $query = self::query();
        if ($parent) {
            $query = $query->where('parent_id', 0);
        }
        $query->orderBy('ordering', 'asc');
        return $query;
    }

    public function getPublishedCategories($parent = false)
    {
        return $this->getListCategory($parent)->where('published', self::PUBLISHED_ON);
    }

    public function getAll($params,$parent = false)
    {
        $query = self::select(['*']);
        if (isset($params['name'])) {
            $query = $query->where('name', 'like', '%' . $params['name'] . '%');
            $query = $query->orWhere('description', 'like', '%' . $params['name'] . '%');
        }
        if ($parent) {
            $query = $query->where('parent_id', 0);
        }
        $query->orderBy('ordering', 'asc');
        return $query->orderBy('id');
    }

    public static function getListCategoryByParentId($parent_id = Null)
    {
        $query =  self::query();
        $query = $query->where('parent_id', $parent_id);
        $query->where('published', self::PUBLISHED_ON)->orderBy('ordering');
        return $query;
    }

    public function getCategoryTitleByID($id){
        $category = self::whereId($id)->first();
        return $category;
    }

    public function getCategoryByName($category_name)
    {
        return self::where('name', $category_name)->first();
    }

    public function getPublishedCategory($category_id)
    {
        return self::where('id', $category_id)->where('published', self::PUBLISHED_ON);
    }

    public function getDiscovery($limit = 10)
    {
        return self::where('published', self::PUBLISHED_ON)->orderBy('ordering', 'asc')->limit($limit);
    }
}
