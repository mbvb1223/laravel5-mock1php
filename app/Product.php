<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{
    protected $guarded = ['id'];
    protected $table = 'product';
    public $properties = array('id', 'key_product', 'name_product', 'status', 'price_import', 'price', 'cost', 'image',
        'information', 'category_id', 'selloff_id', 'style_id', 'madein_id',
        'material_id', 'height_id', 'created_at', 'updated_at');
    public $timestamps = true;

    const STATUS_SHOW = 0;
    const STATUS_HIDDEN = 1;
    const STATUS_DELETE = 2;


    /**
     * getData for pagination using ajax bootgrid
     * @param $allRequest
     * @return mixed
     */

    public function getDataForPaginationAjax($allRequest)
    {
        $pageCurrent = $allRequest['current'];
        $limit       = $allRequest['rowCount'];
        $offset      = ($pageCurrent - 1) * $limit;

        // Config sort
        $sortBy    = 'id';
        $sortOrder = 'asc';

        if (isset($allRequest['sort'])) {
            $sort      = $allRequest['sort'];
            $sortColum = ['id', 'key_product', 'name_product', 'status', 'price_import', 'price', 'cost', 'image',
                'information', 'category_id', 'selloff_id', 'style_id', 'madein_id',
                'material_id', 'height_id', 'created_at', 'updated_at'];
            $sortBy    = (in_array(key($sort), $sortColum)) ? key($sort) : 'id';
            $sortOrder = current($sort);
        }

        $query   = $this->where(function($query) use ($allRequest) {
                                $query->where('id', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
                                    ->orWhere('key_product', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
                                    ->orWhere('name_product', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
                                    ->orWhere('style_id', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
                                    ->orWhere('madein_id', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
                                    ->orWhere('material_id', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
                                    ->orWhere('height_id', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
                                    ->orWhere('created_at', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
                                    ->orWhere('updated_at', 'LIKE', '%' . $allRequest['searchPhrase'] . '%');
                        })->where('status','<>', self::STATUS_DELETE);

        $queryGetTotal = $query;
        $total         = $queryGetTotal->count();

        if ($limit == -1) {
            $rows = $query->orderBy($sortBy, $sortOrder)
                ->get();
        } else {
            $rows = $query->orderBy($sortBy, $sortOrder)
                ->skip($offset)
                ->take($limit)
                ->get();
        }

        // Render field action
        foreach ($rows as $k => $item) {
            $rows[$k]['action'] = create_field_action('admin/product', $item->id);
        }

        $data['current']  = intval($pageCurrent);
        $data['rowCount'] = intval($limit);
        $data['total']    = intval($total);
        $data['rows']     = $rows;
        $data['_token']   = csrf_token();
        return json_encode($data);
    }

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

    public static function mapProductIdToInformationProduct()
    {
        $products = self::all()->toArray();

        if ($products == null) {
            return null;
        }
        foreach ($products as $product) {
            $mapProductIdToInformationProduct[$product['id']] = $product;
        }
        return $mapProductIdToInformationProduct;
    }

    public function getViewAllStatusForProduct($idSelected = 99)
    {
        if ($idSelected == 1) {
            $result = "<option value='" . self::STATUS_SHOW . "' > Show </option> ";
            $result .= "<option value='" . self::STATUS_HIDDEN . "' selected='selected'> Hidden </option> ";
        } else {
            $result = "<option value='" . self::STATUS_SHOW . "' selected='selected'> Show </option> ";
            $result .= "<option value='" . self::STATUS_HIDDEN . "'> Hidden </option> ";
        }

        return $result;
    }


}

