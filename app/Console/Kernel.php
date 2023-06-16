<?php

namespace App\Console;

use App\Http\Controllers\CampaignEventsController;
use App\Http\Controllers\EmailInboxController;
use App\Http\Controllers\EnvelopeController;
use App\Models\Contract;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    public $contractsExcept = [
        'voided',
        // 'completed',
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')->hourly();
        

        $schedule->call(function(){
            $inboxService = new EmailInboxController();
            $inboxService->cron();
        })->name('fetch_inboxes')->withoutOverlapping(1)->everyThreeMinutes();
        
        $schedule->call(function(){
            $envelopeService = new EnvelopeController();
            $contracts = Contract::whereNotIn('status', $this->contractsExcept)
            ->each(function($item) use($envelopeService) {
                $envelopeService->updateStatus(null, $item);
            });
        })->name('update_contract_status')->withoutOverlapping(1)->everyTwoMinutes();;
        
        $schedule->call(function(){
            $service = new CampaignEventsController();
            $service->handle();
        })->name('campaign_event_tasks')->withoutOverlapping(1)->everyTenMinutes();

        

        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}