<?php

namespace App\Console\Commands;

use App\Services\GeneralService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpireOldPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:expire-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire old pending payments';

    /**
     * Execute the console command.
     */




    protected $generalService;

    public function __construct(GeneralService $generalService)
    {
        parent::__construct();
        $this->generalService = $generalService;
    }

    public function handle()
    {
        $this->generalService->expireOldPayments();
        $this->info('Old pending payments expired successfully.');
        // Log the information
        Log::info('Old pending payments expired successfully.');
    }
}
