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
        $title       = 'Dashboard - Height';
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
        return view('height.list');
    }

    public function create()
    {
        return view('height.create');
    }

    public function store(HeightRequest $request)
    {
        $allRequest = $request->all();
        $objHeight  = new Height();
        autoAssignDataToProperty($objHeight, $allRequest);
        $objHeight->save();
        return redirect()->action('HeightController@create')
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

        $model  = new Height;
        $result = $model->getDataForPaginationAjax($dataRequest, $config);

        # Render field action
        foreach ($result['rows'] as $k => $item) {
            $result['rows'][$k]['action'] = create_field_action('admin/height', $item->id);
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
        $objHeight      = new Height;
        $dataHeightById = $objHeight->find($id);

        if ($dataHeightById == null) {
            return redirect()->action('HeightController@index')->withErrors(Lang::get('messages.no_id'));
        }

        return view('height.edit')->with('dataHeightById', $dataHeightById);;
    }

    public function update(HeightRequest $request, $id)
    {
        $allRequest     = $request->all();
        $objHeight      = new Height();
        $dataHeightById = $objHeight->find($id);

        if ($dataHeightById == null) {
            return redirect()->action('HeightController@index')->withErrors(Lang::get('messages.no_id'));
        }
        autoAssignDataToProperty($dataHeightById, $allRequest);
        $dataHeightById->save();
        return redirect()->action('HeightController@index')->withSuccess(Lang::get('messages.update_success'));
    }

    public function destroy($id)
    {
        $objHeight      = new Height();
        $dataHeightById = $objHeight->find($id);

        if ($dataHeightById == null) {
            return redirect()->action('HeightController@index')->withErrors(Lang::get('messages.no_id'));
        }

        $dataHeightById->delete();
        return redirect_success('HeightController@index', Lang::get('messages.delete_success'));
    }

}

