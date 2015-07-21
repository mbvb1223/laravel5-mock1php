<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Color extends Model
{
    protected $guarded = ['id'];
    protected $table = 'color';
    public $properties = array('id', 'color_name', 'created_at', 'updated_at');
    public $timestamps = true;


    /**
     * getData for pagination using ajax bootgrid
     * @param $allRequest
     * @param $config
     * @return mixed
     */

    public function getDataForPaginationAjax($allRequest)
    {
        $pageCurrent = $allRequest['current'];
        $limit       = $allRequest['rowCount'];
        $offset      = ($pageCurrent - 1) * $limit;

        $config = array(
            'limit'  => $limit,
            'offset' => $offset,
        );

        // Config sort
        $sortBy    = 'id';
        $sortOrder = 'asc';

        if (isset($allRequest['sort'])) {
            $sort      = $allRequest['sort'];
            $sortColum = ['id', 'color_name', 'created_at', 'updated_at'];
            $sortBy    = (in_array(key($sort), $sortColum)) ? key($sort) : 'id';
            $sortOrder = current($sort);
        }

        $query         = $this->where('id', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
            ->orWhere('color_name', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
            ->orWhere('created_at', 'LIKE', '%' . $allRequest['searchPhrase'] . '%')
            ->orWhere('updated_at', 'LIKE', '%' . $allRequest['searchPhrase'] . '%');

        $queryGetTotal = $query;
        $total         = $queryGetTotal->count();

        if ($config['limit'] == -1) {
            $rows = $query->orderBy($sortBy, $sortOrder)
                ->get();
        } else {
            $rows = $query->orderBy($sortBy, $sortOrder)
                ->skip($config['offset'])
                ->take($config['limit'])
                ->get();
        }

        # Render field action
        foreach ($rows as $k => $item) {
            $rows[$k]['action'] = create_field_action('admin/color', $item->id);
        }

        $data['current']  = $pageCurrent;
        $data['rowCount'] = $limit;
        $data['total']    = $total;
        $data['rows']     = $rows;
        $data['_token']   = csrf_token();
        return json_encode($data);
    }

    public function mapIdToInfoColor()
    {
        $allColor = self::all();
        $newArray = null;
        foreach ($allColor as $color) {
            $newArray[$color['id']] = $color;
        }
        return $newArray;
    }

    public static function mapIdColorToInformationColor()
    {
        $colors = self::all()->toArray();

        if ($colors == null) {
            return null;
        }
        foreach ($colors as $color) {
            $mapIdColorToInformationColor[$color['id']] = $color;
        }
        return $mapIdColorToInformationColor;
    }

}

