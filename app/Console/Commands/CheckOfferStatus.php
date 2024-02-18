<?php

namespace App\Console\Commands;

use App\Mail\SpreadOfferMail;
use App\Models\Company;
use App\Models\Offer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckOfferStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-offer-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $offers = Offer::where('status', true)->get();

        foreach ($offers as $offer) {
            $activationDate = $offer->created_at;
            $currentDate = Carbon::now();
            $differenceInMonths = $activationDate->diffInMonths($currentDate);
            $differenceInDays = $activationDate->diffInDays($currentDate);
            if($differenceInDays > 32){
                $offer->status = 0;
                $offer->save();
            }else if ($differenceInMonths >= 1 && $offer->last_notification_sent < $currentDate->subMonth()) {
                $company = Company::where('CIF',$offer->CIF)->first();
                $userCompany = User::findOrFail($company->id_user);
                Mail::to($userCompany->email)->send(new SpreadOfferMail($userCompany,$offer));
            }
        }
        $this->info('Offer status checked successfully.');
    }
}
