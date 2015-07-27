<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
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
    const CHECK_NEW = 7;

    const PATH_IMAGE = "upload/product";


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

        $arrayFromIdStyleToNameStyle = Style::arrayFromIdStyleToNameStyle();
        foreach ($rows as $k => $item) {
            $id =  $rows[$k]['style_id'];
            $rows[$k]['style_id'] = $arrayFromIdStyleToNameStyle[$id];
        }

        $arrayFromIdMadeinToNameMadein = Madein::arrayFromIdMadeinToNameMadein();
        foreach ($rows as $k => $item) {
            $id =  $rows[$k]['madein_id'];
            $rows[$k]['madein_id'] = $arrayFromIdMadeinToNameMadein[$id];
        }

        $arrayFromIdMaterialToNameMaterial = Material::arrayFromIdMaterialToNameMaterial();
        foreach ($rows as $k => $item) {
            $id =  $rows[$k]['material_id'];
            $rows[$k]['material_id'] = $arrayFromIdMaterialToNameMaterial[$id];
        }

        $arrayFromIdHeightToValueHeight = Height::arrayFromIdHeightToValueHeight();
        foreach ($rows as $k => $item) {
            $id =  $rows[$k]['height_id'];
            $rows[$k]['height_id'] = $arrayFromIdHeightToValueHeight[$id];
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

    public static function getViewAllProductForSelectTag(){
        $all = self::all()->toArray();
        if ($all == null) {
            return null;
        }
        $resulf = "<option value=''> </option>";
        foreach ($all as $item) {
            $resulf .="<option value='".$item['id']."'>".$item['name_product']." </option>";
        }
        return $resulf;
    }

    public function getViewFiveProductRelationForPageProduct($dataProductByIdCategory){
        $result = null;
        foreach($dataProductByIdCategory as $product){
            $linkImage = url("/")."/upload/product/$product[image]";
            $nameProduct = $product['name_product'];
            $linkToProduct = change_alias($product['name_product'])."-".$product['id'];
            $cost = number_format($product['cost'],2);
            $checkNew = Carbon::now()->subDay(self::CHECK_NEW) <  $product['created_at'];
            if($checkNew == true){
                $stickNew = "<div class='sticker sticker-new'></div>";
            }else {
                $stickNew = null;
            }
            if($product['selloff_id']!=0){
                $price = number_format($product['price'],2);
                $checkSale = "<div class='sticker sticker-sale'></div>";
            }else{
                $price = null;
                $checkSale = null;
            }
            $result .="<div>
                <div class='product-item'>
                    <div class='pi-img-wrapper'>
                        <img src='".$linkImage."' class='img-responsive' alt='Berry Lace Dress'>
                        <div>
                            <a href='".$linkImage."' class='btn btn-default fancybox-button'>Zoom</a>
                            <a href='#product-pop-up' class='btn btn-default fancybox-fast-view k-view' data-id='".$product['id']."'>View</a>
                        </div>
                    </div>
                    <h3><a href='".$linkToProduct."'>$nameProduct</a></h3>
                    <div class='pi-price'>$$cost <small class='zprice'> $$price</small></div>
                    <a href='".$linkToProduct."' class='btn btn-default add2cart'>Detail</a>
                    $stickNew
                    $checkSale
                </div>
            </div>";
        }
        return $result;

    }

    public function getViewProductByArrayProduct($dataProductByIdCategory){
        $result = null;
        if(empty($dataProductByIdCategory)){
            return;
        }
        foreach($dataProductByIdCategory as $product){
            $idProduct = $product['id'];
            $linkImage = url("/")."/upload/product/$product[image]";
            $nameProduct = $product['name_product'];
            $linkToProduct = change_alias($product['name_product'])."-".$product['id'];
            $cost = number_format($product['cost'],2);
            $checkNew = Carbon::now()->subDay(self::CHECK_NEW) <  $product['created_at'];
            if($checkNew == true){
                $stickNew = "<div class='sticker sticker-new'></div>";
            }else {
                $stickNew = null;
            }
            if($product['selloff_id']!=0){
                $price = number_format($product['price'],2);
                $checkSale = "<div class='sticker sticker-sale'></div>";
            }else{
                $price = null;
                $checkSale = null;
            }
            $result .="<div>
                <div class='product-item'>
                    <div class='pi-img-wrapper'>
                        <img src='".$linkImage."' class='img-responsive' alt='Berry Lace Dress'>
                        <div>
                            <a href='".$linkImage."' class='btn btn-default fancybox-button'>Zoom</a>
                            <a href='#product-pop-up' class='btn btn-default fancybox-fast-view k-view'data-id='".$idProduct."'>View</a>
                        </div>
                    </div>
                    <h3><a href='".action('FrontendController@product',$linkToProduct)."'>$nameProduct</a></h3>
                    <div class='pi-price'>$$cost <small class='zprice'> $$price</small></div>
                    <a href='".action('FrontendController@product',$linkToProduct)."' class='btn btn-default add2cart'>Detail</a>
                    $stickNew
                    $checkSale
                </div>
            </div>";
        }
        return $result;

    }

    public function getTenProducByArrayIdCategory($getAnyIdChildrentFromIdCategoryMen){
        if (empty($getAnyIdChildrentFromIdCategoryMen)) {
            return;
        } else {
            $flat = 0;
            foreach ($getAnyIdChildrentFromIdCategoryMen as $category_id) {
                $product = $this->where('status',Product::STATUS_SHOW)->where('category_id', $category_id)->orderBy('id', 'desc')->take(2)->get();
                if (empty($product)) {
                    continue;
                }
                $allProduct[] = $product->toArray();
                $flat++;
                if ($flat == 10) {
                    break;
                }
            }

            foreach ($allProduct as $products) {
                foreach ($products as $product) {
                    $newArray[] = $product;
                }
            }
        }
        return $newArray;
    }


}

