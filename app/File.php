<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File extends Model
{
    const PATH_UPLOADS_TASKS = '/uploads/tasks/';

    public static function getStoragePath($id)
    {
        return public_path() . self::PATH_UPLOADS_TASKS . $id . '/';
    }

    public function getPath($id)
    {
        return self::getStoragePath($id) . $this->server_name;
    }

    public function getFileName()
    {
        return $this->name;
    }

    public function setFile(UploadedFile $file, $taskId)
    {
        $filename = str_random(12);
        $isMoved = $file->move(self::getStoragePath($taskId), $filename);
        if ($isMoved) {
            $this->name = $file->getClientOriginalName();
            $this->server_name = $filename;
        }
    }


}
