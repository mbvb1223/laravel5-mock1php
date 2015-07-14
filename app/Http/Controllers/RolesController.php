<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use App\Roles;
use Lang;
use View;
use Route;

class RolesController extends Controller
{


    public function __construct()
    {
        $title = 'Dashboard - Roles';
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
        return view('roles.list');
    }

    public function create()
    {
        return view('roles.create');
    }


    public function store(RoleRequest $request)
    {
        $model=new Roles();
        autoAssignDataToProperty($model,$request->all());
        $model->save();
        return redirect()->action('RolesController@create')
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

        $model = new Roles;
        $result = $model->getDataForPaginationAjax($dataRequest,$config);

        # Render field action
        foreach ($result['rows'] as $k => $item) {
            $result['rows'][$k]['action'] = create_field_action('admin/roles', $item->id);
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
        $result = Roles::find($id);
        /**
         *
         */
        if($result== null) {
            return redirect()->action('RolesController@index')->withErrors(Lang::get('messages.no_id'));
        }

        /**
         * Show view
         */
        return view('roles.edit', compact('result'));
    }

    public function update(RoleRequest $request, $id)
    {
        $data = $request->all();
        $model = Roles::find($id);
        autoAssignDataToProperty($model,$request->all());
        $model->save();
        return redirect()->action('RolesController@index')->withSuccess(Lang::get('messages.update_success'));
    }

    public function destroy($id)
    {
        $result = Roles::find($id);
        if($result == null){
            return redirect()->action('RolesController@index')->withErrors(Lang::get('messages.no_id'));
        }
        $result->delete();
        return redirect_success('RolesController@index',Lang::get('messages.delete_success'));
    }

}

