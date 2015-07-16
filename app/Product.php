<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{
    protected $guarded = ['id'];
    protected $table = 'product';
    public $properties = array('id', 'key_product', 'name_product','price_import', 'price', 'cost', 'image',
        'information', 'category_id', 'selloff_id', 'style_id', 'madein_id',
        'material_id', 'height_id', 'created_at', 'updated_at');
    public $timestamps = true;


    /**
     * getData for pagination using ajax bootgrid
     * @param $dataRequest
     * @param $config
     * @return mixed
     */

    public function getDataForPaginationAjax($dataRequest, $config)
    {
        // Config sort
        $sortBy    = 'id';
        $sortOrder = 'asc';
        if (isset($dataRequest['sort'])) {
            $sort      = $dataRequest['sort'];
            $sortColum = ['id', 'key_product', 'name_product', 'email', 'style_id', 'madein_id',
                'material_id', 'height_id', 'created_at', 'updated_at'];
            $sortBy    = (in_array(key($sort), $sortColum)) ? key($sort) : 'id';
            $sortOrder = current($sort);
        }

        $query         = $this->where('id', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%')
            ->orWhere('key_product', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%')
            ->orWhere('name_product', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%')
            ->orWhere('style_id', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%')
            ->orWhere('madein_id', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%')
            ->orWhere('material_id', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%')
            ->orWhere('height_id', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%')
            ->orWhere('created_at', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%')
            ->orWhere('updated_at', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%');
        $queryGetTotal = $query;
        $total         = $queryGetTotal->count();

        if ($config['limit'] == -1) {
            $rows = $query->orderBy($sortBy, $sortOrder)
                ->get();
        } else {
            $rows = $query->orderBy($sortBy, $sortOrder)
                ->skip($config['offset'])
                ->take($config['limit'])
                ->get();
        }

        return ['total' => $total, 'rows' => $rows];
    }

    /**
     * array Selloff[$key]=>$value ($key = Selloff['id'] ; $value = Selloff['selloff_value'])
     * @return array
     */
    public static function arrayFromIdToValueOfSelloff()
    {
        $allSelloff = Selloff::all()->toArray();
        if ($allSelloff == null) {
            return null;
        }
        $arrayFromIdToValueOfSelloff = array();
        foreach ($allSelloff as $selloff) {
            $arrayFromIdToValueOfSelloff[$selloff['id']] = $selloff['selloff_value'];
        }
        return $arrayFromIdToValueOfSelloff;
    }

    public static function mapProductIdToInformationProduct(){
        $products = Product::all()->toArray();

        if($products == null){
            return null;
        }
        foreach($products as $product){
            $mapProductIdToInformationProduct[$product['id']] = $product;
        }
        return $mapProductIdToInformationProduct;
    }



}

