<?php

namespace App\Console\Commands;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RemoveUnacceptedStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'students:remove-unaccepted';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove unaccepted students after six days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sixDaysAgo = Carbon::now()->subDays(6);
        $students = Student::where('accept', 0)
            ->where('created_at', '<=', $sixDaysAgo)
            ->whereHas('user', function ($query) use ($sixDaysAgo) {
                $query->where('created_at', '==', $sixDaysAgo);
            })
            ->get();

        foreach ($students as $student) {
            $student->delete();
        }

        $this->info('Unaccepted students removed successfully.');
    }
}
