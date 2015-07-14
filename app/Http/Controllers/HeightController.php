<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\HeightRequest;
use App\Height;
use Lang;
use View;
use Route;

class HeightController extends Controller
{


    public function __construct()
    {
        $title = 'Dashboard - Height';
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
        return view('height.list');
    }

    public function create()
    {
        return view('height.create');
    }


    public function store(HeightRequest $request)
    {
        $model=new Height();
        autoAssignDataToProperty($model,$request->all());
        $model->save();
        return redirect()->action('HeightController@create')
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

        $model = new Height;
        $result = $model->getDataForPaginationAjax($dataRequest,$config);

        # Render field action
        foreach ($result['rows'] as $k => $item) {
            $result['rows'][$k]['action'] = create_field_action('admin/height', $item->id);
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
        $result = height::find($id);
        /**
         *
         */
        if($result== null) {
            return redirect()->action('heightController@index')->withErrors(Lang::get('messages.no_id'));
        }

        /**
         * Show view
         */
        return view('height.edit', compact('result'));
    }

    public function update(HeightRequest $request, $id)
    {
        $allRequest = $request->all();
        $model = Height::find($id);

        if($model== null) {
            return redirect()->action('HeightController@index')->withErrors(Lang::get('messages.no_id'));
        }
        autoAssignDataToProperty($model,$allRequest);
        $model->save();
        return redirect()->action('HeightController@index')->withSuccess(Lang::get('messages.update_success'));
    }

    public function destroy($id)
    {
        $result = Height::find($id);
        if($result == null){
            return redirect()->action('HeightController@index')->withErrors(Lang::get('messages.no_id'));
        }
        $result->delete();
        return redirect_success('HeightController@index',Lang::get('messages.delete_success'));
    }

}

