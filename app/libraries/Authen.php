<?php
namespace App\libraries;
use App\Roles;
use App\Permission;
use App\Users;
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
            'status' =>$data['status'],
            'role_id' => $data['role_id'],
        ];


        Session::put('user', $user);
    }

    public static function checkLoginToBackEnd() {
        //check role == member
        if(Session::get('user')['role_id'] == Users::MEMBER) {
            return false;
        }
        return true;
    }
    public static function checkStatus() {
        //check role == member
        if(Session::get('user')['status'] == Users::INACTIVE) {
            return false;
        }
        return true;
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