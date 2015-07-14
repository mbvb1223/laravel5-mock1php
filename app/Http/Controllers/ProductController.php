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

        /**
         * Get all Category for Options of Select (Category)
         * @return string
         */
        $categories          = Category::all()->toArray();
        $allOptionOfCategory = null;
        getAllCategory($categories, $parent = 0, $text = "", $select = 0, $allOptionOfCategory);

        /**
         * Get all Style for Option of Select (Style)
         * @return array
         */
        $allStyle = Style::all()->toArray();

        /**
         * Get all Madein for Option of Select (Made in)
         * @return array
         */
        $allMadein = Madein::all()->toArray();

        /**
         * Get all Material for Option of Select (Material)
         * @return array
         */
        $allMaterial = Material::all()->toArray();

        /**
         * Get all Height for Option of Select (Height)
         * @return array
         */
        $allHeight = Height::all()->toArray();

        /**
         * Get all Selloff for Option of Select (Selloff)
         * @return array
         */
        $allSelloff = Selloff::all()->toArray();

        /**
         * array Selloff[$key]=>$value ($key = Selloff['id'] ; $value = Selloff['selloff_value'])
         * @return array
         */
        $arrayFromIdToValueOfSelloff = Product::arrayFromIdToValueOfSelloff();


        return view("product.create")->with([
            'allOptionOfCategory'         => $allOptionOfCategory,
            'allStyle'                    => $allStyle,
            'allMadein'                   => $allMadein,
            'allMaterial'                 => $allMaterial,
            'allHeight'                   => $allHeight,
            'allSelloff'                  => $allSelloff,
            'arrayFromIdToValueOfSelloff' => $arrayFromIdToValueOfSelloff,
        ]);
    }


    public function store(ProductRequest $request)
    {
        //Get all Request
        $allRequest = $request->all();

        //Upload file to public/product
        $fileName = UploadImage::uploadImageProduct('image');
        //Assign name for image product
        $allRequest['image'] = $fileName;

        $model = new Product();
        autoAssignDataToProperty($model, $allRequest);
        $model->save();
        return redirect()->action('ProductController@create')
            ->withSuccess(Lang::get('messages.create_success'));
    }

    public function getDataAjax(Request $request)
    {
        $dataRequest = $request->all();

        $pageCurrent = $dataRequest['current'];
        $limit       = $dataRequest['rowCount'];
        $offset      = ($pageCurrent - 1) * $limit;

        $config = array(
            'limit'  => $limit,
            'offset' => $offset,
        );

        $model  = new Product();
        $result = $model->getDataForPaginationAjax($dataRequest, $config);

        # Render field action
        foreach ($result['rows'] as $k => $item) {
            $result['rows'][$k]['action'] = create_field_action('admin/product', $item->id);
        }

        $data['current']  = $pageCurrent;
        $data['rowCount'] = $limit;
        $data['total']    = $result['total'];
        $data['rows']     = $result['rows'];
        $data['_token']   = csrf_token();
        die(json_encode($data));
    }

    public function edit($id)
    {
        $result = Product::find($id);
        /**
         * Check ID product in Database
         */
        if ($result == null) {
            return redirect()->action('ProductController@index')->withErrors(Lang::get('messages.no_id'));
        }

        /**
         * Get all Category for Options of Select (Category)
         * @return string
         */
        $iDSelectedCategory  = $result['category_id'];
        $categories          = Category::all()->toArray();
        $allOptionOfCategory = null;
        getAllCategory($categories, $parent = 0, $text = "", $iDSelectedCategory, $allOptionOfCategory);

        /**
         * Get all Style for Option of Select (Style)
         * @return array
         */
        $allStyle         = Style::all()->toArray();
        $iDSelectedStyle  = $result['style_id'];
        $allOptionOfStyle = null;
        getAllStyle($allStyle, $iDSelectedStyle, $allOptionOfStyle);

        /**
         * Get all Madein for Option of Select (Made in)
         * @return array
         */
        $allMadein         = Madein::all()->toArray();
        $iDSelectedMadein  = $result['madein_id'];
        $allOptionOfMadein = null;
        getAllMadein($allMadein, $iDSelectedMadein, $allOptionOfMadein);

        /**
         * Get all Material for Option of Select (Material)
         * @return array
         */
        $allMaterial         = Material::all()->toArray();
        $iDSelectedMaterial  = $result['material_id'];
        $allOptionOfMaterial = null;
        getAllMaterial($allMaterial, $iDSelectedMaterial, $allOptionOfMaterial);

        /**
         * Get all Height for Option of Select (Height)
         * @return array
         */
        $allHeight         = Height::all()->toArray();
        $iDSelectedHeight  = $result['height_id'];
        $allOptionOfHeight = null;
        getAllHeight($allHeight, $iDSelectedHeight, $allOptionOfHeight);

        /**
         * Get all Selloff for Option of Select (Selloff)
         * @return array
         */
        $allSelloff = Selloff::all()->toArray();
        $iDSelectedSelloff  = $result['selloff_id'];
        $allOptionOfSelloff = null;
        getAllSelloff($allSelloff, $iDSelectedSelloff, $allOptionOfSelloff);

        /**
         * array Selloff[$key]=>$value ($key = Selloff['id'] ; $value = Selloff['selloff_value'])
         * @return array
         */
        $arrayFromIdToValueOfSelloff = Product::arrayFromIdToValueOfSelloff();


        /**
         * Show view
         */
        return view('product.edit', compact('result'))->with([
            'allOptionOfCategory'         => $allOptionOfCategory,
            'allStyle'                    => $allStyle,
            'allMadein'                   => $allMadein,
            'allMaterial'                 => $allMaterial,
            'allHeight'                   => $allHeight,
            'allSelloff'                  => $allSelloff,
            'arrayFromIdToValueOfSelloff' => $arrayFromIdToValueOfSelloff,
            'allOptionOfStyle'            => $allOptionOfStyle,
            'allOptionOfMadein'           => $allOptionOfMadein,
            'allOptionOfMaterial'         => $allOptionOfMaterial,
            'allOptionOfHeight'           => $allOptionOfHeight,
            'allOptionOfSelloff' => $allOptionOfSelloff,
        ]);
    }

    public function update(ProductRequest $request)
    {
        $allRequest = $request->all();
        $id = $allRequest['id'];
        $result      = Product::find($id);
        if ($result == null) {
            return redirect()->action('ProductController@index')->withErrors(Lang::get('messages.no_id'));
        }
        $image = Input::file('image');
        //If don't upload image
        if ($image == null) {
            unset($allRequest['image']);
        } else {

            //If upload image -> delete old image
            $fileNameDelete = "upload/product/".$result['image'];
            if (\File::exists($fileNameDelete)) {
                \File::delete($fileNameDelete);
            }
            //If upload image -> upload new image
            if (Input::file('image')->isValid()) {
                $destinationPath = "upload/product";
                $fileName = change_alias($image->getClientOriginalName()) . time() . "." . $image->getClientOriginalExtension();
                Input::file('image')->move($destinationPath, $fileName);
            }
            //Assign name for image
            $allRequest['image'] = $fileName;
        }
        autoAssignDataToProperty($result, $allRequest);
        $result->save();
        return redirect()->action('ProductController@index')->withSuccess(Lang::get('messages.update_success'));
    }

    public function destroy($id)
    {
        $result = Roles::find($id);
        if ($result == null) {
            return redirect()->action('RolesController@index')->withErrors(Lang::get('messages.no_id'));
        }
        $result->delete();
        return redirect_success('RolesController@index', Lang::get('messages.delete_success'));
    }

    protected function arrayFromIdToNameOfStyle()
    {
        $allStyle = Style::all()->toArray();
        if ($allStyle == null) {
            return null;
        }
        $returnNewArrayOfAllStyle = array();
        foreach ($allStyle as $Style) {
            $returnNewArrayOfAllStyle[$Style['id']] = $Style['style_name'];
        }
        return $returnNewArrayOfAllStyle;
    }


}

