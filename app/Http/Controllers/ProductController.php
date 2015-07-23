<?php
namespace App\Http\Controllers;

use App\Height;
use App\Http\Requests;
use App\Http\Requests\ProductRequest;
use App\Madein;
use App\Material;
use App\Selloff;
use App\Style;
use Illuminate\Http\Request;
use App\libraries\UploadImage;
use App\Product;
use App\Category;
use Lang;
use View;
use Route;
use Input;

class ProductController extends Controller
{


    public function __construct()
    {
        $title       = 'Dashboard - Product';
        $class_name  = substr(__CLASS__, 21);
        $action_name = substr(strrchr(Route::currentRouteAction(), "@"), 1);
        View::share(array(
            'title'       => $title,
            'class_name'  => $class_name,
            'action_name' => $action_name,
        ));
    }

    public function index()
    {
        return view('product.list');
    }

    public function create()
    {
        $objProduct                 = new Product();
        $getViewAllStatusForProduct = $objProduct->getViewAllStatusForProduct();

        $categories                     = Category::all()->toArray();
        $getViewAllCategoryForSelectTag = null;
        getAllCategoryForSelectTag($categories, $parent = 0, $text = "", $select = 0, $getViewAllCategoryForSelectTag);

        $getViewAllStyleForSelectTag    = Style::getViewAllStyleForSelectTag();

        $getViewAllMadeInForSelectTag   = Madein::getViewAllMadeInForSelectTag();

        $getViewAllMaterialForSelectTag = Material::getViewAllMaterialForSelectTag();

        $getViewAllHeightForSelectTag   = Height::getViewAllHeightForSelectTag();

        $getViewAllSellOffForSelectTag  = Selloff::getViewAllSellOffForSelectTag();

        $arrayFromIdToValueOfSelloff    = Product::arrayFromIdToValueOfSelloff();


        return view("product.create")->with([
            'getViewAllStatusForProduct'     => $getViewAllStatusForProduct,
            'getViewAllCategoryForSelectTag' => $getViewAllCategoryForSelectTag,
            'getViewAllStyleForSelectTag'    => $getViewAllStyleForSelectTag,
            'getViewAllMadeInForSelectTag'   => $getViewAllMadeInForSelectTag,
            'getViewAllMaterialForSelectTag' => $getViewAllMaterialForSelectTag,
            'getViewAllHeightForSelectTag'   => $getViewAllHeightForSelectTag,
            'getViewAllSellOffForSelectTag'  => $getViewAllSellOffForSelectTag,
            'arrayFromIdToValueOfSelloff'    => $arrayFromIdToValueOfSelloff,
        ]);
    }


    public function store(ProductRequest $request)
    {
        //Get all Request
        $allRequest = $request->all();

        //Upload file to public/upload/product
        $fileName = UploadImage::uploadImageProduct('image');

        //Convert Money From String To Value
        $allRequest['price_import'] = convertStringToValueOfMoney($allRequest['price_import']);
        $allRequest['price']        = convertStringToValueOfMoney($allRequest['price']);
        $allRequest['cost']         = convertStringToValueOfMoney($allRequest['cost']);
        //Assign name for image product
        $allRequest['image'] = $fileName;

        $objProduct = new Product();
        autoAssignDataToProperty($objProduct, $allRequest);
        $objProduct->save();

        return redirect()->action('ProductController@create')
            ->withSuccess(Lang::get('messages.create_success'));
    }

    public function getDataAjax(Request $request)
    {
        $allRequest               = $request->all();

        $objProduct                 = new Product();
        $getDataForPaginationAjax = $objProduct->getDataForPaginationAjax($allRequest);

        return $getDataForPaginationAjax;
    }

    public function edit($id)
    {
        $objProduct     = new Product();
        $getProductById = $objProduct->find($id);

        if ($getProductById == null) {
            return redirect()->action('ProductController@index')->withErrors(Lang::get('messages.no_id'));
        }
        $idSelectedOfStatus         = $getProductById['status'];
        $getViewAllStatusForProduct = $objProduct->getViewAllStatusForProduct($idSelectedOfStatus);

        $idSelectedOfCategory           = $getProductById['category_id'];
        $categories                     = Category::all()->toArray();
        $getViewAllCategoryForSelectTag = null;
        getAllCategoryForSelectTag($categories, $parent = 0, $text = "", $idSelectedOfCategory, $getViewAllCategoryForSelectTag);

        $idSelectedOfStyle           = $getProductById['style_id'];
        $getViewAllStyleForSelectTag = Style::getViewAllStyleForSelectTag($idSelectedOfStyle);

        $idSelectedOfMadein           = $getProductById['madein_id'];
        $getViewAllMadeInForSelectTag = Madein::getViewAllMadeInForSelectTag($idSelectedOfMadein);

        $idSelectedOfMaterial           = $getProductById['material_id'];
        $getViewAllMaterialForSelectTag = Material::getViewAllMaterialForSelectTag($idSelectedOfMaterial);

        $idSelectedOfHeight           = $getProductById['height_id'];
        $getViewAllHeightForSelectTag = Height::getViewAllHeightForSelectTag($idSelectedOfHeight);

        $idSelectedOfSellOff           = $getProductById['selloff_id'];
        $getViewAllSellOffForSelectTag = Selloff::getViewAllSellOffForSelectTag($idSelectedOfSellOff);

        $arrayFromIdToValueOfSelloff = Product::arrayFromIdToValueOfSelloff();


        return view('product.edit')->with([
            'getProductById'                 => $getProductById,
            'getViewAllStatusForProduct'     => $getViewAllStatusForProduct,
            'arrayFromIdToValueOfSelloff'    => $arrayFromIdToValueOfSelloff,
            'getViewAllCategoryForSelectTag' => $getViewAllCategoryForSelectTag,
            'getViewAllStyleForSelectTag'    => $getViewAllStyleForSelectTag,
            'getViewAllMadeInForSelectTag'   => $getViewAllMadeInForSelectTag,
            'getViewAllMaterialForSelectTag' => $getViewAllMaterialForSelectTag,
            'getViewAllHeightForSelectTag'   => $getViewAllHeightForSelectTag,
            'getViewAllSellOffForSelectTag'  => $getViewAllSellOffForSelectTag,
        ]);
    }

    public function update(ProductRequest $request)
    {
        $allRequest     = $request->all();
        $idProduct      = $allRequest['id'];
        $objProduct     = new Product();
        $getProductByid = $objProduct->find($idProduct);

        if ($getProductByid == null) {
            return redirect()->action('ProductController@index')->withErrors(Lang::get('messages.no_id'));
        }
        //Convert Money From String To Value
        $allRequest['price_import'] = convertStringToValueOfMoney($allRequest['price_import']);
        $allRequest['price']        = convertStringToValueOfMoney($allRequest['price']);
        $allRequest['cost']         = convertStringToValueOfMoney($allRequest['cost']);

        $nameInputUploadImageProduct = 'image';
        $NameFileImageNeedToDelete   = $getProductByid['image'];
        $newAllRequest               = UploadImage:: uploadNewImageAndDeleteOldImageProduct($nameInputUploadImageProduct, $allRequest, $NameFileImageNeedToDelete);
        autoAssignDataToProperty($getProductByid, $newAllRequest);
        $getProductByid->save();

        return redirect()->action('ProductController@edit', $idProduct)->withSuccess(Lang::get('messages.update_success'));
    }

    public function destroy($id)
    {
        $objProduct     = new Product();
        $getProductById = $objProduct->find($id);

        if ($getProductById == null) {
            return redirect()->action('ProductController@index')->withErrors(Lang::get('messages.no_id'));
        }
        $getProductById->status = Product::STATUS_DELETE;
        $getProductById->save();
        return redirect_success('ProductController@index', Lang::get('messages.delete_success'));
    }

}

