<?php
namespace App\libraries;

use Input;

class UploadImage
{
    public static function uploadImage($name) {
        $image = Input::file($name);

        if (Input::file($name)->isValid()) {
            $destinationPath = "upload/images";
            $fileName = change_alias($image->getClientOriginalName()) . time() . "." . $image->getClientOriginalExtension();
            Input::file($name)->move($destinationPath, $fileName);
        }
       return $fileName;

    }

    public static function uploadImageProduct($name) {
        $image = Input::file($name);
        if (Input::file($name)->isValid()) {
            $destinationPath = "upload/product";
            $fileName = change_alias($image->getClientOriginalName()) . time() . "." . $image->getClientOriginalExtension();
            Input::file($name)->move($destinationPath, $fileName);
        }
        return $fileName;

    }


}