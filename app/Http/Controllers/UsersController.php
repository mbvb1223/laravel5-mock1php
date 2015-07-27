<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserEditRequest;
use Illuminate\Http\Request;
use App\Users;
use App\Roles;
use App\City;
use App\Region;
use App\libraries\UploadImage;
use App\libraries\Authen;
use Illuminate\Support\Facades\Auth;
use Lang;
use View;
use Route;
use Input;
use Mail;


class UsersController extends Controller
{


    public function __construct()
    {
        $title       = 'Dashboard - Users';
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
        return view('users.list');
    }

    public function create()
    {
        $roles                  = Roles::all();
        $status                 = array(
            'active'   => Users::ACTIVE,
            'inactive' => Users::INACTIVE,
        );
        $getViewSelectTagCity   = City::getViewSelectTagCity();
        $mapIdCityToArrayRegion = Region::mapIdCityToArrayRegion();
        return view('users.create')->with([
            "roles"                  => $roles,
            "status"                 => $status,
            'getViewSelectTagCity'   => $getViewSelectTagCity,
            'mapIdCityToArrayRegion' => $mapIdCityToArrayRegion,
        ]);
    }

    public function edit($id)
    {
        $idUser = $id;
        $result = Users::find($id);
        $roles  = Roles::all();
        $status = array(
            'active'   => Users::ACTIVE,
            'inactive' => Users::INACTIVE,
        );
        //Get Informtion of User
        $mapIdUserToInfoUser = Users::mapIdUserToInfoUser();

        //Get all City for select tag with City selected

        $idCityOfUser         = $mapIdUserToInfoUser[$idUser]['city_id'];
        $getViewSelectTagCity = City::getViewSelectTagCity($idCityOfUser);

        //Get all Region for select tag with Region selected
        $idRegionOfUser         = $mapIdUserToInfoUser[$idUser]['region_id'];
        $getViewSelectTagRegion = Region::getViewSelectTagRegion($idRegionOfUser);

        //Map Id city to array Region for: select city then select region
        $mapIdCityToArrayRegion = Region::mapIdCityToArrayRegion();

        return view('users.edit')->with([
            "result"                 => $result,
            "status"                 => $status,
            "roles"                  => $roles,
            'mapIdCityToArrayRegion'                     => $mapIdCityToArrayRegion,
            'getViewSelectTagCity'   => $getViewSelectTagCity,
            'getViewSelectTagRegion' => $getViewSelectTagRegion,
        ]);

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

        $model  = new Users;
        $result = $model->getDataForPaginationAjax($dataRequest, $config);

        # Render field action
        foreach ($result['rows'] as $k => $item) {
            $result['rows'][$k]['action'] = create_field_action('admin/users', $item->id);
        }

        //Show Name Roles to List User
        $arrayIdToNameRoles = $this->arrayIdToNameRoles();
        foreach ($result['rows'] as $k => $item) {
            $id                            = $result['rows'][$k]['role_id'];
            $result['rows'][$k]['role_id'] = $arrayIdToNameRoles[$id];
        }

        //Show Status
        foreach ($result['rows'] as $k => $item) {
            if ($result['rows'][$k]['status'] == "1") {
                $result['rows'][$k]['status'] = "Active";
            } elseif ($result['rows'][$k]['status'] == "0") {
                $result['rows'][$k]['status'] = "Inctive";
            }
        }

        $data['current']  = intval($pageCurrent);
        $data['rowCount'] = intval($limit);
        $data['total']    = intval($result['total']);
        $data['rows']     = $result['rows'];
        $data['_token']   = csrf_token();
        die(json_encode($data));
    }


    public function store(UserRequest $request)
    {
        $allRequest = $request->all();

        $model = new Users();
        //upload avatar
        $fileName = UploadImage::uploadImage('avatar');

        //Set attribute -> save()
        $allRequest['avatar']         = $fileName;
        $allRequest['keyactive']      = md5(time());
        $allRequest['remember_token'] = hash('sha256', time() . $fileName);
        $allRequest['password']       = bcrypt($allRequest['password']);
        autoAssignDataToProperty($model, $allRequest);
        $model->save();

        if ($allRequest['status'] == Users::INACTIVE) {
            //Sent mail to this user for active account
            $userInfo = $model->toArray();
            Mail::send('mail.welcome', ['userInfo' => $userInfo], function ($message) use ($userInfo) {
                $message->subject("Welcome to khienpc");
                $message->from('khienpc.sosc@gmail.com');
                $message->to($userInfo['email']);
            });

        }

        //redirect page
        return redirect()->action('UsersController@index')->withSuccess(Lang::get('messages.create_success'));
    }


    public function update(UserEditRequest $request, $id)
    {
        $allRequest = $request->all();
        $model      = Users::find($id);

        $avatar = Input::file('avatar');
        //If don't upload image
        if ($avatar == null) {
            unset($allRequest['avatar']);
        } else {
            //If upload image -> delete old image
            $fileNameDelete = "upload/images/" . $model['avatar'];
            if (\File::exists($fileNameDelete)) {
                \File::delete($fileNameDelete);
            }
            //If upload image -> upload new image
            if (Input::file('avatar')->isValid()) {
                $destinationPath = "upload/images";
                $fileName        = change_alias($avatar->getClientOriginalName()) . time() . "." . $avatar->getClientOriginalExtension();
                Input::file('avatar')->move($destinationPath, $fileName);
            }
            //Assign name for avatar
            $allRequest['avatar'] = $fileName;
        }
        //if don't have password -> unset password
        if ($allRequest['password'] == null) {
            unset($allRequest['password']);
        }

        autoAssignDataToProperty($model, $allRequest);
        $model->save();
        return redirect()->action('UsersController@index')->withSuccess(Lang::get('messages.update_success'));

    }

    public function destroy($id)
    {
        Users::find($id)->delete();
        return redirect_success('UsersController@index', Lang::get('messages.delete_success'));
    }

    public function active($id, $key)
    {
        $checkUser = Users::where(array('id'        => $id,
                                        'keyactive' => $key))->count();

        if ($checkUser != 0) {
            $model         = Users::find($id);
            $model->status = Users::ACTIVE;
            $model->save();
            Authen::setUser($model);

        }
        Auth::logout();
        return redirect('auth/login')->withSuccess(Lang::get('messages.active_successful'));
    }

    protected function arrayIdToNameRoles()
    {
        $roles = Roles::all()->toArray();
        if ($roles == null) {
            return null;
        }
        $newArray = array();
        foreach ($roles as $roles) {
            $newArray[$roles['id']] = $roles['rolename'];
        }
        return $newArray;
    }

}

