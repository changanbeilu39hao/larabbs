<?php

namespace App\Handlers;

use Illuminate\Support\Str;

class ImageUploadHandler
{
    protected $allow_ext = ['jpg', 'png', 'gif', 'jpeg'];

    public function save($file, $folder,$file_prefix)
    {
        //1.构建存储文件夹的规则
        $folder_name = "uploads/images/$folder/" . date("Ym/d", time());

        $upload_path = public_path() . '/' . $folder_name;

        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;
        
        //2.检验是不是图片
        if (! in_array($$extension, $this->allow_ext)){
            return false;
        }

        //3.将上传的文件移动到文件夹中
        $file->move($upload_path, $filename);

        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];
    
    }
}