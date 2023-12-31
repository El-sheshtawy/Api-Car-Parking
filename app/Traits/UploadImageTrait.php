<?php

namespace App\Traits;

trait UploadImageTrait
{
    public function uploadImage($imageInputName, $directory)
    {
        if (request($imageInputName)) {
            $file = request($imageInputName);
            $name = "{$directory}/". uniqid() . '.' . $file->extension();
            $file->storePubliclyAs('public', $name);
            return $name;
        }
        return null;
    }
}
