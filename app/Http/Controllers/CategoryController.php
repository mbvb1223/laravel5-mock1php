<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Category;
use Lang;
use View;
use Route;
use Input;
use Mail;


class CategoryController extends Controller
{
    public function __construct()
    {
        $title       = 'Dashboard - Category';
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
        $allCategory = Category::all()->toArray();

        if (empty($allCategory)) {
            return redirect()->action('HomeController@index')
                ->withErrors(Lang::get('messages.table_category_empty'));
        }

        $getAllCategoryForSelectTag = null;
        getAllCategoryForSelectTag($allCategory, $parent = 0, $text = "", $select = 0, $getAllCategoryForSelectTag);

        return View::make('category.list', ['getAllCategoryForSelectTag' => $getAllCategoryForSelectTag]);
    }

    public function getDataForJstree()
    {
        $objCategory                 = new Category();
        $arrayDataConvertedForJstree = $objCategory->getDataForJstree();
        return $arrayDataConvertedForJstree;
    }

    public function create()
    {
        $allCategory = Category::all()->toArray();

        $getAllCategoryForSelectTag = null;
        getAllCategoryForSelectTag($allCategory, $parent = 0, $text = "", $select = 0, $getAllCategoryForSelectTag);

        return view('category.create')->with([
            "getAllCategoryForSelectTag" => $getAllCategoryForSelectTag,

        ]);
    }

    public function update(CategoryRequest $request)
    {
        $allRequest             = $request->all();
        $idCategoryNeedToUpdate = $allRequest['id'];

        $objCategory      = new Category();
        $dataCategoryById = $objCategory->find($idCategoryNeedToUpdate);
        autoAssignDataToProperty($dataCategoryById, $allRequest);
        $dataCategoryById->save();

        return redirect()->action('CategoryController@index')->withSuccess(Lang::get('messages.update_success'));
    }

    public function delete(Request $request)
    {
        $allRequest             = $request->all();
        $idCategoryNeedToDelete = $allRequest['id'];

        $objCategory      = new Category();
        $dataCategoryById = $objCategory->find($idCategoryNeedToDelete);

        if (empty($dataCategoryById)) {
            return redirect()->action('CategoryController@index')->withErrors(Lang::get('messages.no_id'));
        }

        $checkChildren = $objCategory->where('parent', $dataCategoryById->id)->count();
        if ($checkChildren != 0) {
            return redirect()->action('CategoryController@index')->withErrors(Lang::get('messages.has_childrent'));
        }

        $dataCategoryById->delete();

        return redirect()->action('CategoryController@index')->withSuccess(Lang::get('messages.delete_success'));


    }

    public function store(CategoryRequest $request)
    {
        $objCategory = new Category();
        autoAssignDataToProperty($objCategory, $request->all());
        $objCategory->save();
        return redirect()->action('CategoryController@index')
            ->withSuccess(Lang::get('messages.create_success'));
    }


}

