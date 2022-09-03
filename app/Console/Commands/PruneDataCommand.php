<?php

namespace App\Console\Commands;

use App\Models\ApiKey;
use App\Models\ServerStat;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class PruneDataCommand extends Command
{
    protected $signature = 'prune:api-key {--maxAge=7}';
    protected $description = 'Prune API keys not active for --maxAge=. min value 7 days. Default: 60';

    public function handle(): int
    {
        $maxAge = $this->option('maxAge');

        if ($maxAge < 7) {
            $this->error('can\'t delete data newer than 7 days.');

            return 0;
        }
		ServerStat::where('created_at', '<', now()->subDays($maxAge))->delete();

        $apiKeys = ApiKey::whereHas('data', function (Builder $query) use ($maxAge) {
            $query->where('created_at', '>=', now()->subDays($maxAge));
        }, '=', 0)->delete();

        $this->info(sprintf('found and deleted %s api keys not used in the last %s days.', $apiKeys, $maxAge));

        return 1;
    }
}
