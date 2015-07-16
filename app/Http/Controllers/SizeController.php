<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\SizeRequest;
use App\Size;
use Lang;
use View;
use Route;

class SizeController extends Controller
{


    public function __construct()
    {
        $title       = 'Dashboard - Size';
        $class_name  = substr(__CLASS__, 21);
        $action_name = substr(strrchr(Route::currentRouteAction(), "@"), 1);
        View::share(array(
            'title'       => $title,
            'class_name'  => $class_name,
            'action_name' => $action_name,
        ));
        $this->afterFilter(function () {
            // something
        });
    }

    public function index()
    {
        return view('size.list');
    }

    public function create()
    {
        return view('size.create');
    }


    public function store(SizeRequest $request)
    {
        $model = new Size();
        autoAssignDataToProperty($model, $request->all());
        $model->save();
        return redirect()->action('SizeController@create')
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

        $model  = new Size;
        $result = $model->getDataForPaginationAjax($dataRequest, $config);

        # Render field action
        foreach ($result['rows'] as $k => $item) {
            $result['rows'][$k]['action'] = create_field_action('admin/size', $item->id);
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
        $result = Size::find($id);
        /**
         *
         */
        if ($result == null) {
            return redirect()->action('SizeController@index')->withErrors(Lang::get('messages.no_id'));
        }

        /**
         * Show view
         */
        return view('size.edit', compact('result'));
    }

    public function update(SizeRequest $request)
    {
        $allRequest = $request->all();
        $id = $allRequest['id'];
        $model      = Size::find($id);

        if ($model == null) {
            return redirect()->action('SizeController@index')->withErrors(Lang::get('messages.no_id'));
        }
        autoAssignDataToProperty($model, $allRequest);
        $model->save();
        return redirect()->action('SizeController@index')->withSuccess(Lang::get('messages.update_success'));
    }

    public function destroy($id)
    {
        $result = Size::find($id);
        if ($result == null) {
            return redirect()->action('SizeController@index')->withErrors(Lang::get('messages.no_id'));
        }
        $result->delete();
        return redirect_success('SizeController@index', Lang::get('messages.delete_success'));
    }

}

