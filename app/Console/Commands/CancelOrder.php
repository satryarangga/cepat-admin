<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderPayment;

class CancelOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel Unpaid Order Using Transfer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cancelledOrderId = OrderPayment::jobCancelOrder();
        $total = count($cancelledOrderId);
        echo "Cancel $total orders\n";
    }
}
