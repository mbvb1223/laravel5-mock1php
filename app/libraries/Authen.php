<?php
namespace libraries;
use App\Roles;
use App\Permission;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

class Authen
{
    public static function setUser($data) {
        $user =[
            'id' => $data['id'],
            'username' =>$data['username'],
            'email' => $data['email'],
            'avatar' => $data['avatar'],
            'role_id' => $data['role_id'],

        ];


        Session::put('user', $user);
    }

    public static function checkLogin() {
        if(Session::get('user')) {
            return true;
        }
        return false;
    }

    public static function getUser() {
        return Session::get('user');
    }

    public static function checkPermission() {
        $userInfo = Session::get('user');
        $routesInPermission = new Permission();
        $currentRoute = Route::getFacadeRoot()->current()->uri();
        $checkPermission=$routesInPermission->where('route',$userInfo['role_id'].'|'.$currentRoute)->count();
        if($checkPermission>0 || $userInfo['role_id']==1) {
            return true;
        }
        return false;
    }

}