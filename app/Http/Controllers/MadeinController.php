<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\MadeinRequest;
use Illuminate\Http\Request;
use App\Madein;
use Lang;
use View;
use Route;

class MadeinController extends Controller
{


    public function __construct()
    {
        $title = 'Dashboard - Made in';
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
        return view('madein.list');
    }

    public function create()
    {
        return view('madein.create');
    }


    public function store(MadeinRequest $request)
    {
        $model=new Madein();
        autoAssignDataToProperty($model,$request->all());
        $model->save();
        return redirect()->action('MadeinController@create')
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

        $model = new Madein;
        $result = $model->getDataForPaginationAjax($dataRequest,$config);

        # Render field action
        foreach ($result['rows'] as $k => $item) {
            $result['rows'][$k]['action'] = create_field_action('admin/madein', $item->id);
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
        $result = madein::find($id);
        /**
         *
         */
        if($result== null) {
            return redirect()->action('madeinController@index')->withErrors(Lang::get('messages.no_id'));
        }

        /**
         * Show view
         */
        return view('madein.edit', compact('result'));
    }

    public function update(MadeinRequest $request, $id)
    {
        $allRequest = $request->all();
        $model = madein::find($id);
        autoAssignDataToProperty($model,$allRequest);
        $model->save();
        return redirect()->action('MadeinController@index')->withSuccess(Lang::get('messages.update_success'));
    }

    public function destroy($id)
    {
        $result = Madein::find($id);
        if($result == null){
            return redirect()->action('MadeinController@index')->withErrors(Lang::get('messages.no_id'));
        }
        $result->delete();
        return redirect_success('MadeinController@index',Lang::get('messages.delete_success'));
    }

}

