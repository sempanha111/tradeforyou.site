<?php

namespace App\Console\Commands;

use App\Services\GeneralService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RecallSetupWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:recall-setup-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Still Setup webhook for another user pending payments';


    protected $generalService;

    public function __construct(GeneralService $generalService)
    {
        parent::__construct();
        $this->generalService = $generalService;
    }

    public function handle()
    {
        $this->generalService->RecallPaymentWebhook();
        $this->info('Run Set up webhook successfully.');
        // Log the information
        Log::info('Run Set up webhook successfully.');
    }
}
