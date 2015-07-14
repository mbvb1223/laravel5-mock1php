<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\MaterialRequest;
use Illuminate\Http\Request;
use App\Material;
use Lang;
use View;
use Route;

class MaterialController extends Controller
{


    public function __construct()
    {
        $title = 'Dashboard - Material';
        $class_name= substr(__CLASS__,21);
        $action_name=substr(strrchr(Route::currentRouteAction(),"@"),1);
        View::share(array(
            'title'=> $title,
            'class_name'=> $class_name,
            'action_name'=> $action_name,
        ));
        $this->afterFilter(function() {
            // something
        });
    }
    public function index()
    {
        return view('material.list');
    }

    public function create()
    {
        return view('material.create');
    }


    public function store(MaterialRequest $request)
    {
        $model=new Material();
        autoAssignDataToProperty($model,$request->all());
        $model->save();
        return redirect()->action('MaterialController@create')
                         ->withSuccess(Lang::get('messages.create_success'));
    }

    public function getDataAjax(Request $request)
    {
        $dataRequest = $request->all();

        $pageCurrent = $dataRequest['current'];
        $limit = $dataRequest['rowCount'];
        $offset = ($pageCurrent -1)*$limit;

        $config = array(
            'limit'=>$limit,
            'offset'=>$offset,
        );

        $model = new Material;
        $result = $model->getDataForPaginationAjax($dataRequest,$config);

        # Render field action
        foreach ($result['rows'] as $k => $item) {
            $result['rows'][$k]['action'] = create_field_action('admin/material', $item->id);
        }

        $data['current'] = $pageCurrent;
        $data['rowCount'] = $limit;
        $data['total'] = $result['total'];
        $data['rows'] = $result['rows'];
        $data['_token'] = csrf_token();
        die(json_encode($data));
    }
    public function edit($id)
    {
        $result = Material::find($id);
        /**
         *
         */
        if($result== null) {
            return redirect()->action('MaterialController@index')->withErrors(Lang::get('messages.no_id'));
        }

        /**
         * Show view
         */
        return view('material.edit', compact('result'));
    }

    public function update(MaterialRequest $request, $id)
    {
        $allRequest = $request->all();
        $model = Material::find($id);

        if($model== null) {
            return redirect()->action('MaterialController@index')->withErrors(Lang::get('messages.no_id'));
        }
        autoAssignDataToProperty($model,$allRequest);
        $model->save();
        return redirect()->action('MaterialController@index')->withSuccess(Lang::get('messages.update_success'));
    }

    public function destroy($id)
    {
        $result = material::find($id);
        if($result == null){
            return redirect()->action('MaterialController@index')->withErrors(Lang::get('messages.no_id'));
        }
        $result->delete();
        return redirect_success('MaterialController@index',Lang::get('messages.delete_success'));
    }

}

