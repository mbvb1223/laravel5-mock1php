<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserEditRequest;
use Illuminate\Http\Request;
use App\Category;
use libraries\UploadImage;
use libraries\Authen;
use Illuminate\Support\Facades\Auth;
use Lang;
use View;
use Route;
use Input;
use Mail;


class CategoryController extends Controller
{


    public function __construct()
    {
        $title = 'Dashboard - Category';
        $class_name = substr(__CLASS__, 21);
        $action_name = substr(strrchr(Route::currentRouteAction(), "@"), 1);
        View::share(array(
            'title' => $title,
            'class_name' => $class_name,
            'action_name' => $action_name,
        ));
        $this->afterFilter(function () {
            // something
        });
    }

    public function index()
    {
        $categories = Category::all()->toArray();

        return View::make('category.list', ['categories' => $categories]);
    }

    public function getJsonData()
    {
        $categories = Category::all();
//        foreach($categories as $category){
//            $categories[] = Category::where('parent', '=', $category['id'])->get();
//         }
//        dd($categories->toArray());
        //dd($categories->toArray());
        foreach ($categories as $category) {
            if ($category['parent'] == 0) {
                $category['parent'] = "#";
            }
            $newCategoryConvert[] = array('id' => $category['id'],
                'parent' => $category['parent'],
                'text' => $category['category_name'],
            );

        }

        return $newCategoryConvert;
    }
    public function create()
    {
        $categories = Category::all()->toArray();
       // getAllCategory($categories);
//        dd($categories);
//        foreach($categories as $category){
//
//        }


//        $categories = Category::where('parent',0)->get();
//        foreach($categories as $category){
//            $data[] = $category;
//            foreach($data as $key){
//
//            }
//           Category::where('parent',$category['id'])->get();
//        }
//        dd($categories->toArray());
//        getAllCategory($data,$parent,$prefix);

        return view('category.create')->with([
            "categories" => $categories,

        ]);

    }
    public function update(Request $request)
    {
        $allRequest = $request->all();
        $model = Category::find($allRequest['id']);

        autoAssignDataToProperty($model,$request->all());
        $model->save();
        return redirect()->action('CategoryController@index')->withSuccess(Lang::get('messages.update_success'));


    }
    public function delete(Request $request)
    {
        $allRequest = $request->all();
        $model = Category::find($allRequest['id']);
        if(Category::where('parent', $model->id)->count() !=0){
            return redirect()->action('CategoryController@index')->withErrors(Lang::get('messages.has_childrent'));
        }
        $model->delete();
        return redirect()->action('CategoryController@index')->withSuccess(Lang::get('messages.delete_success'));


    }

    public function store(Request $request)
    {
        $model=new Category();
        autoAssignDataToProperty($model,$request->all());
        $model->save();
        return redirect()->action('CategoryController@index')
            ->withSuccess(Lang::get('messages.create_success'));
    }


}

