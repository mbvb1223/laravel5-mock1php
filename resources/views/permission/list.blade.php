@extends('layouts.admin.master')
@section('css')
<link href="<?php echo url("/"); ?>/../theme/assets/global/css/jquery.bootgird.min.css" rel="stylesheet"
      type="text/css"/>
@stop


@section('content')
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal form-row-seperated" action="{{ URL::action('PermissionController@store') }}"
              method="Post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-shopping-cart"></i><?php echo Lang::get('messages.list_permission'); ?>
                    </div>
                    <div class="actions">
                        <button class="btn green" type="submit">
                            <i class="fa fa-check"></i>  <?php echo Lang::get('messages.update'); ?>
                        </button>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th><?php echo Lang::get('messages.permission_routes'); ?></th>
                            <?php foreach ($roles as $role) : ?>
                                <th><?php echo $role['rolename']; ?></th>
                            <?php endforeach; ?>

                        </tr>

                        <?php foreach ($routes as $route) : ?>
                            <tr>
                                <td><?php echo $route; ?></td>
                                <?php foreach ($roles as $role) : ?>
                                    <?php $valueInInput = $role['id'] . "|" . $route;
                                    if ($routesInTablePermission == null) : ?>
                                        <td>
                                            <input type="checkbox" name="data[]"
                                               value="<?php echo $role['id']; ?>|<?php echo $route; ?>"/>
                                        </td>
                                   <?php else : ?>
                                       <?php if (in_array($valueInInput,$routesInTablePermission)): ?>
                                            <td>
                                                <input type="checkbox" name="data[]"
                                                       value="<?php echo $role['id']; ?>|<?php echo $route; ?>"
                                                       checked="checked"/>
                                            </td>
                                       <?php else : ?>
                                            <td>
                                                <input type="checkbox" name="data[]"
                                                       value="<?php echo $role['id']; ?>|<?php echo $route; ?>"/>
                                            </td>
                                       <?php  endif; ?>
                                   <?php endif; ?>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                        </thead>
                    </table>
                </div>
            </div>
        </form>
    </div>
    @stop


