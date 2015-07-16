<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Permission;
use App\Roles;
use Illuminate\Routing\Router;
use Lang;
use View;
use Route;

class PermissionController extends Controller
{
    public function __construct()
    {
        $title       = 'Dashboard - Permission';
        $class_name  = substr(__CLASS__, 21);
        $action_name = substr(strrchr(Route::currentRouteAction(), "@"), 1);
        View::share(array(
            'title'       => $title,
            'class_name'  => $class_name,
            'action_name' => $action_name,
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //Get all routes
        $routeCollection = Route::getRoutes();
        if ($routeCollection == null) {
            return;
        }
        foreach ($routeCollection as $value) {
            $allRoutes[] = $value->getPath();
            $routes      = array_unique($allRoutes);
        }
        // Get all rocord in table permission in database
        $permissions = Permission::all()->toArray();

        //Get column route in table permission
        if (empty($permissions)) {
            $routesInTablePermission = null;
        } else {
            foreach ($permissions as $permission) {
                $routesInTablePermission[] = $permission['route'];
            }
        }


        //Get all Roles
        $roles = Roles::all();
        return view("permission.list")->with([
            'routes'                  => $routes,
            'roles'                   => $roles,
            'routesInTablePermission' => $routesInTablePermission,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $dataSubmits = $request['data'];
        if ($dataSubmits == null) {
            return;
        }
        Permission::truncate();
        $models = new Permission();
        //dd($dataSubmit);

        foreach ($dataSubmits as $dataSubmit) {
            $dataSave[] = array('route' => $dataSubmit);
        }

        $models->insert($dataSave);

        return redirect()->action('PermissionController@index')
            ->withSuccess(Lang::get('messages.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
