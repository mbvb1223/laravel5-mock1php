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

    public static function uploadNewImageAndDeleteOldImageProduct($name, $allRequest, $NameFileImageNeedToDelete) {
        $image = Input::file($name);
        //If don't upload image
        if ($image == null) {
            unset($allRequest[$name]);
        } else {
            //If upload image -> delete old image
            $fileNameDelete = "upload/product/" .$NameFileImageNeedToDelete;
            if (\File::exists($fileNameDelete)) {
                \File::delete($fileNameDelete);
            }
            //If upload image -> upload new image
            if ($image->isValid()) {
                $destinationPath = "upload/product";
                $fileName        = change_alias($image->getClientOriginalName()) . time() . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $fileName);
            }
            //Assign name for image
            $allRequest['image'] = $fileName;
        }
        return $allRequest;

    }


}