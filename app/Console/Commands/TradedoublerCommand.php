<?php

namespace App\Console\Commands;

use App\Services\Tradedoubler\Program;
use Illuminate\Console\Command;

class TradedoublerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tradedoubler {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commande de Tradedoubler';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        switch ($this->argument('action')) {
            case 'applyAds':
                return $this->applyAds();
        }
    }

    private function applyAds()
    {
        $program = new Program();
        $i = 0;
        foreach ($program->list()->items as $item) {
            if ($item->statusId == 0) {
                $program->apply($item->id);
                $i++;
            }
        }
        $this->info("Nombre de programme demander: ".$i);
        return 0;
    }
}
