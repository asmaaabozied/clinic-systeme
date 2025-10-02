<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Charge;
use Illuminate\Support\Facades\File;

class UpdateChargeCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-charge-codes';

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
        $path = base_path('database/data/charges_code_map.json');

        if (!File::exists($path)) {
            $this->error("JSON file not found at $path");
            return;
        }

        $chargeData = json_decode(File::get($path), true);

        foreach ($chargeData as $item) {
            $charge = Charge::where('charge_name', $item['charge_name'])
                ->first();
            if ($charge && $charge->code) {
                $this->info("Already has code: {$item['charge_name']} => Code: {$charge->code}");
                continue;
            }

            if ($charge) {
                $charge->code = $item['code'];
                $charge->save();
                $this->info("Updated: {$item['charge_name']} => Code: {$item['code']}");
            } else {
                //try by like
                $charge = Charge::where('charge_name', 'like', '%' . $item['charge_name'] . '%')
                    ->whereNull('code')
                    ->first();
                if ($charge) {
                    $charge->code = $item['code'];
                    $charge->save();
                    $this->info("Updated (by like): {$item['charge_name']} => Code: {$item['code']}");
                } else {
                    // If still not found, log a warning
                    $this->warn("Not found: {$item['charge_name']}");
                }
                $this->warn("Not found: {$item['charge_name']}");
            }
        }

        $this->info("Code update complete.");
    }
}
