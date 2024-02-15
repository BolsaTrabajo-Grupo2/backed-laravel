<?php

namespace App\Console\Commands;

use App\Models\Student;
use App\Models\User;
use App\Notifications\AccountActivationReminder;
use App\Notifications\NewStudentOrCompanyNotification;
use Carbon\Carbon;

use Illuminate\Console\Command;
use Illuminate\Notifications\Notification;

class SendActivationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send-activation';
    protected $description = 'Send activation reminders to students after three days';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threeDaysAgo = Carbon::now()->subDays(3);

        $students = Student::where('accept', 0)->get()->filter(function ($student) use ($threeDaysAgo) {
            return Carbon::parse($student->created_at)->toDateString() === $threeDaysAgo->toDateString();
        });
        foreach ($students as $student) {
            $user = User::find($student->id_user);
            if ($user) {
                $user->notify(new AccountActivationReminder($student));

            }
        }

        $this->info('Activation reminders sent successfully.');
    }
}
