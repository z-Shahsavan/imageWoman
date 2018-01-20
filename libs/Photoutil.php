<?php

class Photoutil {

    public static function photocheck($id) {
        //check is set
        if (isset($_FILES[$id])) {
            //check not empty
            if (strcmp($_FILES[$id]['name'], '') != 0) {
                //check image extentions
                $ext = explode(".", $_FILES[$id]['name']);
                $ext = end($ext);
                $allowext = ALLOW_EXTENTIONS;
                $allowext = explode(',', $allowext);
                if (in_array(strtolower($ext), $allowext)) {
                    //check mimetype
                    $tempFile = $_FILES[$id]['tmp_name'];
                    $imginfo_array = getimagesize($tempFile);
                    if ($imginfo_array !== false) {
                        $mime_type = $imginfo_array['mime'];
                        $ext = '';
                        switch ($mime_type) {
                            case "image/jpeg":
                            case "image/pjpeg":
                                $ext = 'jpg';
                                break;
                            case "image/png":
                                $ext = 'png';
                                break;
                            case "image/bmp":
                                $ext = 'bmp';
                                break;
                            case "image/gif":
                                $ext = 'gif';
                                break;
                        }
                        if (in_array(strtolower($ext), $allowext)) {
                            //check image not corrupted
                            if (ImageCreateFromString(file_get_contents($tempFile)) != false) {
                                //check image file size
                                $inbyte = (IMAGE_MAX_SIZE * 1024) * 1024;
                                if ($_FILES[$id]['size'] > $inbyte) {
                                    //image is large file size
                                    return 5;
                                } else {
                                    //check image size height and width
                                    list($width, $height, $type, $attr) = getimagesize($tempFile);
                                    if (IMAGE_MIN_HEIGHT > $height || IMAGE_MIN_WIDTH > $width) {
                                        //image is little
                                        return 4;
                                    } else {
                                        return $ext;
                                    }
                                }
                            } else {
                                //image is corrupted
                                return 3;
                            }
                        } else {
                            //mimetype not true
                            return 2;
                        }
                    } else {
                        //mimetype not true
                        return 2;
                    }
                } else {
                    //extention not true
                    return 2;
                }
            } else {
                //file is empty
                return 1;
            }
        } else {
            //file not set
            return 1;
        }
    }

    public static function avatarcheck($id) {
        //check is set
        if (isset($_FILES[$id])) {
            //check not empty
            if (strcmp($_FILES[$id]['name'], '') != 0) {
                //check image extentions
                $ext = explode(".", $_FILES[$id]['name']);
                $ext = end($ext);
                $allowext = ALLOW_EXTENTIONS;
                $allowext = explode(',', $allowext);
                if (in_array(strtolower($ext), $allowext)) {
                    //check mimetype
                    $tempFile = $_FILES[$id]['tmp_name'];
                    $imginfo_array = getimagesize($tempFile);
                    if ($imginfo_array !== false) {
                        $mime_type = $imginfo_array['mime'];
                        $ext = '';
                        switch ($mime_type) {
                            case "image/jpeg":
                            case "image/pjpeg":
                                $ext = 'jpg';
                                break;
                            case "image/png":
                                $ext = 'png';
                                break;
                            case "image/bmp":
                                $ext = 'bmp';
                                break;
                            case "image/gif":
                                $ext = 'gif';
                                break;
                        }
                        if (in_array(strtolower($ext), $allowext)) {
                            //check image not corrupted
                            if (ImageCreateFromString(file_get_contents($tempFile)) != false) {
                                //check image file size
                                //$inbyte = (AVATAR_MAX_SIZE * 1024);
                                //if ($_FILES[$id]['size'] > $inbyte) {
                                    //image is large file size
                                    //return 4;
                               // } else {

                                    return $ext;
                              //  }
                            } else {
                                //image is corrupted
                                return 3;
                            }
                        } else {
                            //mimetype not true
                            return 2;
                        }
                    } else {
                        //mimetype not true
                        return 2;
                    }
                } else {
                    //extention not true
                    return 2;
                }
            } else {
                //file is empty
                return 1;
            }
        } else {
            //file not set
            return 1;
        }
    }

    
    public static function logocheck($id) {
        //check is set
        if (isset($_FILES[$id])) {
            //check not empty
            if (strcmp($_FILES[$id]['name'], '') != 0) {
                //check image extentions
                $ext = explode(".", $_FILES[$id]['name']);
                $ext = end($ext);
                $allowext = 'png';
                $allowext = explode(',', $allowext);
                if (in_array(strtolower($ext), $allowext)) {
                    //check mimetype
                    $tempFile = $_FILES[$id]['tmp_name'];
                    $imginfo_array = getimagesize($tempFile);
                    if ($imginfo_array !== false) {
                        $mime_type = $imginfo_array['mime'];
                        $ext = '';
                        switch ($mime_type) {
                            case "image/png":
                                $ext = 'png';
                                break;
                        }
                        if (in_array(strtolower($ext), $allowext)) {
                            //check image not corrupted
                            if (ImageCreateFromString(file_get_contents($tempFile)) != false) {
                                        return $ext;
                            } else {
                                //image is corrupted
                                return 3;
                            }
                        } else {
                            //mimetype not true
                            return 2;
                        }
                    } else {
                        //mimetype not true
                        return 2;
                    }
                } else {
                    //extention not true
                    return 2;
                }
            } else {
                //file is empty
                return 1;
            }
        } else {
            //file not set
            return 1;
        }
    }

    public static function savesitelogo($fid) {
        $imgname = 'logo.png';
        move_uploaded_file($_FILES[$fid]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/' .PROJECTNAME. '/images/sitelogo/' . $imgname);
    }
    
    
    public static function saveimgandthumb($id, $ext, $fid) {
        $imgname = Utilities::imgname('origsize', $id) . '.jpg';
        $thmname = Utilities::imgname('thumb', $id) . '.jpg';
        self::convertImage($_FILES[$fid]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/' .PROJECTNAME. '/images/gallery/origsize/' . $imgname, $ext, 100);
        self::make_thumb($_SERVER['DOCUMENT_ROOT'] . '/' .PROJECTNAME. '/images/gallery/origsize/' . $imgname, $_SERVER['DOCUMENT_ROOT'] . '/' . PROJECTNAME.'/images/gallery/thumb/' . $thmname, 750);
        if (IS_WATEMARK == 1) {
            self::watermark_image($_SERVER['DOCUMENT_ROOT'] . '/' .PROJECTNAME. '/images/gallery/origsize/' . $imgname);
        }
    }

    public static function convertImage($originalImage, $outputImage, $ext, $quality) {
        if (preg_match('/jpg|jpeg/i', $ext))
            $imageTmp = imagecreatefromjpeg($originalImage);
        else if (preg_match('/png/i', $ext))
            $imageTmp = imagecreatefrompng($originalImage);
        else if (preg_match('/gif/i', $ext))
            $imageTmp = imagecreatefromgif($originalImage);
        else if (preg_match('/bmp/i', $ext))
            $imageTmp = imagecreatefrombmp($originalImage);
        else
            return 0;
        
        imagejpeg($imageTmp, $outputImage, $quality);
        imagedestroy($imageTmp);
        return 1;
    }

    public static function make_thumb($src, $dest, $desired_width) {

        /* read the source image */
        $source_image = imagecreatefromjpeg($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);

        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));
        $start = ($width - $desired_width) / 2;
        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        /* create the physical thumbnail image to its destination */
        imagejpeg($virtual_image, $dest);
    }
    
    
    public static function make_thumbacatar($src, $dest, $desired_width) {

        /* read the source image */
        $source_image = imagecreatefromjpeg($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);

        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));
        $start = ($width - $desired_width) / 2;
        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        /* create the physical thumbnail image to its destination */
        imagejpeg($virtual_image, $dest);
    }

    public static function watermark_image($input_name) {
        $stamp = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . '/' .PROJECTNAME. '/images/sitelogo/logo.png');
        $im = imagecreatefromjpeg($input_name);
        $marge_right = 1;
        $marge_bottom = 5;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);
        imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
        imagejpeg($im, $input_name, 100); //This part overwrites the image.
        imagedestroy($im);
    }

}
