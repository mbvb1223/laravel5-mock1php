<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model
{
    protected $guarded = ['id'];
    protected $table = 'category';
    public $properties = array('id', 'category_name', 'parent', 'created_at', 'updated_at');

    const MEN = 1;
    const WOMEN = 2;

    public function getDataForJstree()
    {
        $allCategory                 = self::all();
        $arrayDataConvertedForJstree = null;

        foreach ($allCategory as $category) {
            if ($category['parent'] == 0) {
                $category['parent'] = "#";
            }
            $arrayDataConvertedForJstree[] = array('id'     => $category['id'],
                                                   'parent' => $category['parent'],
                                                   'text'   => $category['category_name'],
            );

        }

        return $arrayDataConvertedForJstree;
    }

    public function mapIdCategoryToInfoCategory()
    {
        $allCategory = self::all()->toArray();
        $newArray    = null;
        foreach ($allCategory as $category) {
            $newArray[$category['id']] = $category;
        }
        return $newArray;
    }

    public function getAnyIdParentFromIdCategory($idCategory, $allCategory, &$getAnyIdParentFromIdProduct)
    {
        $getCategoryById = self::find($idCategory);
        if(empty($getCategoryById)){
            return;
        }
        $idParent        = $getCategoryById->parent;
        foreach ($allCategory as $category) {
            if ($category['id'] == $idParent) {
                $getAnyIdParentFromIdProduct[] = intval($category['id']);
                $this->getAnyIdParentFromIdCategory($category['id'], $allCategory, $getAnyIdParentFromIdProduct);
            }
        }
    }
    public function getAnyIdChildrentFromIdCategory($idCategory, $allCategory, &$getAnyIdChildrentFromIdCategory)
    {
        $getCategoryById = self::find($idCategory);
        if(empty($getCategoryById)){
            return;
        }
        $idParent        = $getCategoryById->id;
        foreach ($allCategory as $category) {
            if ($category['parent'] == $idParent) {
                $getAnyIdChildrentFromIdCategory[] = intval($category['id']);
                $this->getAnyIdChildrentFromIdCategory($category['id'], $allCategory, $getAnyIdChildrentFromIdCategory);
            }
        }
    }
}

