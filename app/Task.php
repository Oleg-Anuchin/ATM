<?php

namespace App;

use App\Jobs\SendNewTaskEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;




class Task extends Model
{
    const APP_SENDER_MAIL = 'app@sandboxf86f778dfcbd4366bb5a2578f78f3ee2.mailgun.org';
    const APP_MAIL_FROM = 'ATM';
    const SUBJECT_NEW_TASK = 'Новая задача';

    const CLIENT_SIDE_DEADLINE_FORMAT = 'd.m.Y H:i';
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deadline'];

   public static function boot()
   {
       parent::boot();

       Task::created(function(Task $task)
       {
           $responsibleModel = $task->getResponsibleModel();
           $authorModel = $task->getAuthorModel();

           if ($responsibleModel->id == $authorModel->id) {
               return;
           }

           dispatch(new \App\Jobs\SendNewTaskEmail($task, $authorModel, $responsibleModel, SendNewTaskEmail::TYPE_NEW_TASK_MESSAGE));

//           $author = $authorModel->getName();
//           $responsible = $responsibleModel->getName();
//           $text = $task->title;
//
//           Mail::send('email.new_task', ['responsible' => $responsible, 'author' => $author, 'text' => $text],
//               function ($m) use ($responsibleModel) {
//                   $m->from(Task::APP_SENDER_MAIL, Task::APP_MAIL_FROM);
//                   $m->to($responsibleModel->email, $responsibleModel->getName())->subject(Task::SUBJECT_NEW_TASK);
//           });
       });


   }


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

    public function getAuthorModel() {
        return $this->author()->first();
    }

    public function getResponsibleModel() {
        return $this->responsible()->first();
    }
    
    public function setNotifySend($set) {
        $this->is_notify_send = $set;
    }

}
