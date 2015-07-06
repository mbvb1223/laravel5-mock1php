<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Users extends Model {
    protected $guarded = ['id'];
    protected $table = 'users';
    public $properties = array('id','username','password','email','phone','avatar','status','role_id','remember_token','created_at','updated_at');
    public $timestamps = true;
    const ACTIVE = 1;
    const INACTIVE = 0;

    /**
     * getData for pagination using ajax bootgrid
     * @param $dataRequest
     * @param $config
     * @return mixed
     */

    public function getDataForPaginationAjax($dataRequest,$config){
        // Config sort
        $sortBy = 'id';
        $sortOrder = 'asc';
        if(isset($dataRequest['sort'])) {
            $sort = $dataRequest['sort'];
            $sortColum = ['id','username','password','email','phone','avatar','status','role_id','remember_token','created_at','updated_at'];
            $sortBy = (in_array(key($sort), $sortColum)) ? key($sort) : 'id';
            $sortOrder = current($sort);
        }

        $query = $this->where('id', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
            ->orWhere('username', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
            ->orWhere('password', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
            ->orWhere('email', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
            ->orWhere('phone', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
            ->orWhere('avatar', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
            ->orWhere('status', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
            ->orWhere('role_id', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
            ->orWhere('remember_token', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
            ->orWhere('created_at', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
            ->orWhere('updated_at', 'LIKE', '%'.$dataRequest['searchPhrase'].'%')
        ;
        $queryGetTotal = $query;
        $total = $queryGetTotal->count();

        if($config['limit']== -1){
            $rows = $query->orderBy($sortBy, $sortOrder)
                ->get();
        }else {
            $rows = $query->orderBy($sortBy, $sortOrder)
                ->skip($config['offset'])
                ->take($config['limit'])
                ->get();
        }

        return ['total'=> $total, 'rows'=>$rows];
    }


    /**
     * Log the given user ID into the application.
     *
     * @param  mixed  $id
     * @param  bool   $remember
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
}

