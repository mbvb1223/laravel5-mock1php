<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\ColorRequest;
use App\Color;
use Lang;
use View;
use Route;

class ColorController extends Controller
{
    public function __construct()
    {
        $title       = 'Dashboard - Color';
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
        return view('color.list');
    }

    public function create()
    {
        return view('color.create');
    }

    public function store(ColorRequest $request)
    {
        $allRequest = $request->all();
        $objColor   = new Color();
        autoAssignDataToProperty($objColor, $allRequest);
        $objColor->save();
        return redirect()->action('ColorController@create')
            ->withSuccess(Lang::get('messages.create_success'));
    }

    public function getDataAjax(Request $request)
    {
        $allRequest               = $request->all();
        $objColor                 = new Color;
        $getDataForPaginationAjax = $objColor->getDataForPaginationAjax($allRequest);

        return $getDataForPaginationAjax;
    }

    public function edit($id)
    {
        $objColor     = new Color;
        $dataColorById = $objColor->find($id);

        if ($dataColorById == null) {
            return redirect()->action('ColorController@index')->withErrors(Lang::get('messages.no_id'));
        }

        return view('color.edit')->with('dataColorById',$dataColorById);
    }

    public function update(ColorRequest $request)
    {
        $allRequest   = $request->all();
        $id           = $allRequest['id'];
        $objColor     = new Color;
        $getColorById = $objColor->find($id);

        if ($getColorById == null) {
            return redirect()->action('ColorController@index')->withErrors(Lang::get('messages.no_id'));
        }
        autoAssignDataToProperty($getColorById, $allRequest);
        $getColorById->save();
        return redirect()->action('ColorController@index')->withSuccess(Lang::get('messages.update_success'));
    }

    public function destroy($id)
    {
        $objColor     = new Color;
        $getColorById = $objColor->find($id);

        if ($getColorById == null) {
            return redirect()->action('ColorController@index')->withErrors(Lang::get('messages.no_id'));
        }
        $getColorById->delete();
        return redirect_success('ColorController@index', Lang::get('messages.delete_success'));
    }

}

