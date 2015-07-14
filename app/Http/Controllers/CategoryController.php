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
        /**
         * SET title, class_name, action_name
         */
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
        $categories = Category::all()->toArray();
        $result     = null;
        getAllCategory($categories, $parent = 0, $text = "", $select = 0, $result);

        return View::make('category.list', ['categories' => $result]);
    }

    public function getJsonData()
    {
        $categories = Category::all();
        foreach ($categories as $category) {
            if ($category['parent'] == 0) {
                $category['parent'] = "#";
            }
            $newCategoryConvert[] = array('id'     => $category['id'],
                                          'parent' => $category['parent'],
                                          'text'   => $category['category_name'],
            );

        }

        return $newCategoryConvert;
    }

    public function create()
    {
        $categories = Category::all()->toArray();
        $result     = null;
        getAllCategory($categories, $parent = 0, $text = "", $select = 0, $result);

        return view('category.create')->with([
            "categories" => $result,

        ]);

    }

    public function update(CategoryRequest $request)
    {
        $allRequest = $request->all();
        $model      = Category::find($allRequest['id']);

        autoAssignDataToProperty($model, $request->all());
        $model->save();
        return redirect()->action('CategoryController@index')->withSuccess(Lang::get('messages.update_success'));


    }

    public function delete(Request $request)
    {
        $allRequest = $request->all();
        $model      = Category::find($allRequest['id']);
        if ($model == null) {
            return redirect()->action('CategoryController@index')->withErrors(Lang::get('messages.no_id'));
        }
        if (Category::where('parent', $model->id)->count() != 0) {
            return redirect()->action('CategoryController@index')->withErrors(Lang::get('messages.has_childrent'));
        }
        $model->delete();
        return redirect()->action('CategoryController@index')->withSuccess(Lang::get('messages.delete_success'));


    }

    public function store(CategoryRequest $request)
    {
        $model = new Category();
        autoAssignDataToProperty($model, $request->all());
        $model->save();
        return redirect()->action('CategoryController@index')
            ->withSuccess(Lang::get('messages.create_success'));
    }

//    public function test()
//    {
//        $categories = Category::all()->toArray();
//        $data       = array();
//        getAllCategoryTest($categories, $data);
//        dd($data);
//    }

}

