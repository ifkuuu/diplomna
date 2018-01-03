<?php

namespace Service\Upload;


interface UploadServiceInterface
{

    public function uploadImage($fileInfo, $destinationFolder): string;

    public function uploadMultipleImages($fileInfo, $destinationFolder): array ;

}
