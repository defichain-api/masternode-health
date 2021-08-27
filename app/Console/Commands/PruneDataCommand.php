<?php

namespace App\Console\Commands;

use App\Models\ApiKey;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class PruneDataCommand extends Command
{
    protected $signature = 'prune:api-key {--days=30}';
    protected $description = 'Prune API keys not active for --days=. min value 14 days. Default: 60';

    public function handle(): int
    {
        $maxAge = $this->option('days');

        if ($maxAge < 14) {
            $this->error('can\'t delete data newer than 14 days.');

            return 0;
        }

        $apiKeys = ApiKey::whereHas('data', function (Builder $query) use ($maxAge) {
            $query->where('created_at', '>=', now()->subDays($maxAge));
        }, '=', 0)->delete();

        $this->info(sprintf('found and deleted %s api keys not used in the last %s days.', $apiKeys, $maxAge));

        return 1;
    }
}
