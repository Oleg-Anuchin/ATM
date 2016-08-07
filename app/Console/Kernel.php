<?php

namespace App\Console;

use App\Jobs\SendNewTaskEmail;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Illuminate\Support\Facades\Log;

use App\Task;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            Log::info('Старт задачи отправки уведомлений...');
            $time = Carbon::now();
            $time->addHour(1);
            $tasks = Task::where('deadline', '<=', $time)
                ->where('is_notify_send', false)
                ->get();

            foreach ($tasks as $task) {
                $responsibleModel = $task->getResponsibleModel();
                $authorModel = $task->getAuthorModel();
                dispatch(new \App\Jobs\SendNewTaskEmail($task, $authorModel, $responsibleModel, SendNewTaskEmail::TYPE_DEADLINE_MESSAGE));
                $task->setNotifySend(true);
                $task->save();
            }



        })->everyMinute();

    }
}
