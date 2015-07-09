<?php
namespace App\libraries;

use Input;

class UploadImage
{
    public static function uploadImage($name) {
        $avatar = Input::file($name);

        if (Input::file($name)->isValid()) {
            $destinationPath = "upload/images";
            $fileName = change_alias($avatar->getClientOriginalName()) . time() . "." . $avatar->getClientOriginalExtension();
            Input::file($name)->move($destinationPath, $fileName);
        }

       return $fileName;

    }


}