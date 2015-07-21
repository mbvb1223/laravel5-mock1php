<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model
{
    protected $guarded = ['id'];
    protected $table = 'category';
    public $properties = array('id', 'category_name', 'parent', 'created_at', 'updated_at');

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
        $newArray = null;
        foreach ($allCategory as $category) {
            $newArray[$category['id']] = $category;
        }
        return $newArray;
    }

}

