<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StyleRequest;
use Illuminate\Http\Request;
use App\Style;
use Lang;
use View;
use Route;

class StyleController extends Controller
{


    public function __construct()
    {
        $title = 'Dashboard - Style';
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
        return view('style.list');
    }

    public function create()
    {
        return view('style.create');
    }


    public function store(StyleRequest $request)
    {
        $model=new Style();
        autoAssignDataToProperty($model,$request->all());
        $model->save();
        return redirect()->action('StyleController@create')
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

        $model = new Style;
        $result = $model->getDataForPaginationAjax($dataRequest,$config);

        # Render field action
        foreach ($result['rows'] as $k => $item) {
            $result['rows'][$k]['action'] = create_field_action('admin/style', $item->id);
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
        $result = style::find($id);
        /**
         *
         */
        if($result== null) {
            return redirect()->action('StyleController@index')->withErrors(Lang::get('messages.no_id'));
        }

        /**
         * Show view
         */
        return view('style.edit', compact('result'));
    }

    public function update(StyleRequest $request, $id)
    {
        $allRequest = $request->all();
        $model = Style::find($id);
        autoAssignDataToProperty($model,$allRequest);
        $model->save();
        return redirect()->action('StyleController@index')->withSuccess(Lang::get('messages.update_success'));
    }

    public function destroy($id)
    {
        $result = Style::find($id);
        if($result == null){
            return redirect()->action('StyleController@index')->withErrors(Lang::get('messages.no_id'));
        }
        $result->delete();
        return redirect_success('StyleController@index',Lang::get('messages.delete_success'));
    }

}

