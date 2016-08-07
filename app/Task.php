<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Carbon\Carbon;

class Task extends Model
{
    const CLIENT_SIDE_DEADLINE_FORMAT = 'd.m.Y H:i';
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deadline'];

    //protected $dateFormat = 'd.m.Y H:i';


    public static function getMyTasks(User $user)
    {
        return DB::table('tasks')
            ->join('users as responsible', 'tasks.responsible_id', '=', 'responsible.id')
            ->join('users as author', 'tasks.author_id', '=', 'author.id')
            ->select('tasks.*', 'responsible.name as responsible', 'author.name as author')
            ->where('tasks.responsible_id', '=', $user->id)
            ->get();
    }

    public static function getForMyselfTasks(User $user)
    {
        return DB::table('tasks')
            ->join('users as responsible', 'tasks.responsible_id', '=', 'responsible.id')
            ->join('users as author', 'tasks.author_id', '=', 'author.id')
            ->select('tasks.*', 'responsible.name as responsible', 'author.name as author')
            ->where('tasks.responsible_id', '!=', $user->id)
            ->where('tasks.author_id', '=', $user->id)
            ->get();
    }


    public function author()
    {
        return $this->hasOne('App\User', 'id', 'author_id');
    }

    public function responsible()
    {
        return $this->hasOne('App\User', 'id', 'responsible_id');
    }

    public function getAuthor()
    {
        return $this->author()->first()->getName();
    }

    public function getAuthorId()
    {
        return $this->author_id;
    }

    public function getResponsibleName()
    {
        return $this->responsible()->first()->getName();
    }

    public function setAuthorById($id)
    {
        return $this->author_id = $id;
    }

    public function setResponsibleById($id)
    {
        $this->responsible_id = $id;
    }

    public function getResponsibleId()
    {
        return $this->responsible_id;
    }

    public function getDeadline()
    {
        return 'не указано';
    }

    public function hasFile()
    {
        return $this->file_id != null;
    }

    public function file()
    {
        return $this->hasOne('App\File', 'id', 'file_id');
    }

    public function getFilePath()
    {
        return $this->file()->first()->getPath($this->id);
    }

    public function getFileName()
    {
        return $this->file()->first()->getFileName();
    }

    public function setFile(UploadedFile $uploaded_file)
    {
        $file = new File();
        $file->setFile($uploaded_file, $this->id);
        $file->save();
        $this->file_id = $file->id;
    }

    public function setDeadline($deadline)
    {
        if ($deadline == '') {
            $this->deadline = null;
        } else {
            $this->deadline = Carbon::createFromFormat(self::CLIENT_SIDE_DEADLINE_FORMAT, $deadline);
        }
    }

    public function getDeadlineString()
    {
        if ($this->deadline == null) {
            return 'не указан';
        } else {
            return $this->deadline->format(self::CLIENT_SIDE_DEADLINE_FORMAT);
        }
    }

}
