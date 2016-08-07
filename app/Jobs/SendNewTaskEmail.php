<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Task;
use App\User;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Mail;


class SendNewTaskEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    const APP_SENDER_MAIL = 'app@sandboxf86f778dfcbd4366bb5a2578f78f3ee2.mailgun.org';
    const APP_MAIL_FROM = 'ATM';
    const SUBJECT_NEW_TASK = 'Новая задача: ';
    const SUBJECT_DEADLINE = 'Напоминание о крайнем сроке: ';

    const TYPE_NEW_TASK_MESSAGE = 0;
    const TYPE_DEADLINE_MESSAGE = 1;

    protected $task;
    protected $author;
    protected $responsible;
    protected $type;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Task $task, User $author, User $responsible, $type)
    {
        $this->task = $task;
        $this->author = $author;
        $this->responsible = $responsible;
        $this->type = $type;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $responsibleModel = $this->responsible;
        $author = $this->author->getName();
        $responsible = $this->responsible->getName();
        $text = $this->task->title;

        switch ($this->type) {
            case self::TYPE_NEW_TASK_MESSAGE:
                $mailer->send('email.new_task', ['responsible' => $responsible, 'author' => $author, 'text' => $text],
                    function ($m) use ($responsibleModel, $text) {
                        $m->from(self::APP_SENDER_MAIL, self::APP_MAIL_FROM);
                        $m->to($responsibleModel->email, $responsibleModel->getName())->subject(self::SUBJECT_NEW_TASK .$text);
                    });
                break;

            case self::TYPE_DEADLINE_MESSAGE:
                $mailer->send('email.deadline', ['responsible' => $responsible, 'author' => $author, 'text' => $text],
                    function ($m) use ($responsibleModel, $text) {
                        $m->from(self::APP_SENDER_MAIL, self::APP_MAIL_FROM);
                        $m->to($responsibleModel->email, $responsibleModel->getName())->subject(self::SUBJECT_DEADLINE .$text);
                    });
                break;
        }


    }
}
