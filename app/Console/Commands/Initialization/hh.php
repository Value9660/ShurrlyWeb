<?php

namespace App\Console\Commands;

use App\Models\Seeker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeleteUnverifiedAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-unverified-accounts';

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
        Seeker::where('verified', null)
        ->where('created_at', '<=', '2024-02-10 09:32:39')
        ->delete();

        $this->info('Unverified accounts older than 10 days have been deleted successfully.');
     }
}


