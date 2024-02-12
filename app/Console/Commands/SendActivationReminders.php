<?php

namespace App\Console\Commands;

use App\Models\Student;
use App\Notifications\AccountActivationReminder;
use App\Notifications\NewStudentOrCompanyNotification;
use Carbon\Carbon;
use http\Client\Curl\User;
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

        $students = Student::where('accept', 0)
            ->whereHas('user', function ($query) use ($threeDaysAgo) {
                $query->where('created_at', '<=', $threeDaysAgo);
            })
            ->get();

        foreach ($students as $student) {
            $user = User::find($student->id_user);
            if ($user) {
                Notification::route('mail', $user->email)
                    ->notify(new AccountActivationReminder($student));
            }
        }

        $this->info('Activation reminders sent successfully.');
    }
}
