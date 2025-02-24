<?php

/**
 * Developed by Sohel Rana
 * https://github.com/sohelrn
 */

use Gumlet\ImageResize;

class Uploader
{
    public static function image($file, $config, $createFromString = false)
    {
        $setting = DB::select('settings', 'description', ['name' => 'storage_provider'], 'LIMIT 1');
        $provider_name = isset($setting[0]['description']) ? $setting[0]['description'] : null;
        $result = self::crop($file, $config, $createFromString);
        if (empty($result)) return null;
        if ($provider_name) {
            $provider = new Gateway($provider_name);
            if (!empty($provider->gateway)) {
                $images = [];
                foreach ($result['images'] ?: [] as $key => $val) {
                    $url = $provider->gateway->upload($val['path']);
                    if ($url) {
                        $images[$key] = [
                            'filename' => $val['filename'],
                            'width' => $val['width'],
                            'height' => $val['height'],
                            'url' => $url
                        ];
                    }
                    if (file_exists($val['path'])) unlink($val['path']);
                }
                if (!empty($images)) $result = self::response($result['id'], $result['extension'], $images);
            }
        }
        return $result;
    }

    public static function asset($file, $filename, $width = null, $height = null)
    {
        if (empty($file['name']) || empty($file['tmp_name']) || !is_file($file['tmp_name'])) return null;
        $mime_type = mime_content_type($file['tmp_name']);
        if (!in_array($mime_type, ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])) return null;

        $extension = self::extension($mime_type);
        $filename = $filename . '.' . $extension;
        $path = "assets/img/";
        $save = DIR . '/' . $path . $filename;
        try {
            if (($width == null && $height == null) || ($mime_type == 'image/svg+xml')) {
                move_uploaded_file($file['tmp_name'], $save);
            } else {
                $image = new ImageResize($file['tmp_name']);
                if ($width && $height) {
                    $image->crop($width, $height);
                } else if ($width) {
                    $image->resizeToWidth($width);
                } else if ($height) {
                    $image->resizeToHeight($height);
                }
                $image->save($save, null, 100);
            }

            if (!file_exists($save)) return null;
            $url = $path . $filename;
        } catch (\Exception $e) {
            $url = null;
        }
        return !empty($url) ? $url : null;
    }

    protected static function crop($file, $config, $createFromString = false)
    {
        $file_uuid = md5(microtime(true) . rand()) . uniqid();
        $file_path = "images/";
        $file_root = DIR . '/' . $file_path;
        if (!is_dir($file_root)) {
            if (@mkdir($file_root, 0755, true) === false) return null;
        }

        if ($createFromString) {
            $image = ImageResize::createFromString(base64_decode($file));
        } else {
            if (empty($file['tmp_name']) || !is_file($file['tmp_name'])) return null;
            $image = new ImageResize($file['tmp_name']);
        }

        if ($createFromString) {
            $image_info = getimagesizefromstring(base64_decode($file));
        } else {
            $image_info = getimagesize($file['tmp_name']);
        }

        if ($image_info !== false) {
            $mime_type = $image_info['mime'];
        } else {
            return null;
        }
        if (!in_array($mime_type, ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])) {
            return null;
        }

        try {
            foreach ($config as $key => $val) {
                $width = isset($val['width']) ? $val['width'] : null;
                $height = isset($val['height']) ? $val['height'] : null;
                $file_extension = isset($val['extension']) ? strtolower($val['extension']) : self::extension($mime_type);
                $file_name = (isset($val['filename']) ? $val['filename'] : ($file_uuid . ($key ? '-' . $key : null))) . '.' . $file_extension;
                $save_path = $file_root  . $file_name;

                if (($width == null && $height == null) || ($mime_type == 'image/svg+xml')) {
                    if ($createFromString) {
                        file_put_contents($save_path, base64_decode($file));
                    } else {
                        move_uploaded_file($file['tmp_name'], $save_path);
                    }
                } else {
                    if ($width && $height) {
                        $enlarge = $width == $height ? true : false;
                        $image->crop($width, $height, $enlarge);
                    } else if ($width) {
                        $height = ($width / 4) * 3;
                        $resize_height = (int) ($image->getSourceHeight() * ($width / $image->getSourceWidth()));
                        if ($resize_height > $height) {
                            $image->resizeToWidth($width);
                        } else {
                            $image->crop($width, $height);
                        }
                    } else if ($height) {
                        $image->resizeToHeight($height);
                    } else {
                        $image->crop(256, 256);
                    }
                    $image->save($save_path, $file_extension == 'webp' ? IMAGETYPE_WEBP : ($file_extension == 'jpg' ? IMAGETYPE_JPEG : null));
                }

                if (!file_exists($save_path)) return null;
                $url = $file_path . $file_name;
                $result[$key] = [
                    'filename' => $file_name,
                    'width' => $image->getDestWidth(),
                    'height' => $image->getDestHeight(),
                    'url' => $url,
                ];
            }
        } catch (\Exception $e) {
            //echo $e->getMessage();
            $result = null;
        }

        if (empty($result)) return null;
        return self::response($file_uuid, $file_extension, $result);
    }

    protected static function response($file_id, $file_extension, $file_images)
    {
        return [
            'id' => $file_id,
            'extension' => $file_extension,
            'uploaded' => date("Y-m-d H:i:s"),
            'images' => $file_images,
        ];
    }

    protected static function extension($mime_type)
    {
        $type = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/svg+xml' => 'svg'
        ];
        return isset($type[$mime_type]) ? $type[$mime_type] : null;
    }
}
