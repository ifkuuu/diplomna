<?php

namespace Service\Upload;


class UploadService implements UploadServiceInterface
{

    public function uploadImage($fileInfo, $destinationPath): string
    {
        if (strstr($fileInfo['type'], "image") === false) {
            throw new \Exception("Invalid image format");
        }

        $fileName = $destinationPath
            . DIRECTORY_SEPARATOR . uniqid() . '_' . $fileInfo['name'];


        $result = move_uploaded_file($fileInfo['tmp_name'], $fileName);

        $fileName = dirname($_SERVER['PHP_SELF'])
            . DIRECTORY_SEPARATOR
            . $fileName;

        if ($result == false) {
            throw new \Exception("Upload failed");
        }

        return $fileName;
    }
}
