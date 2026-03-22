<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Services\DynamicLogicService;

class EncryptDynamicLogic extends Command
{
    protected $signature   = 'dynamic:encrypt';
    protected $description = 'Encrypt all plain-text files in storage/app/dynamic_logic';

    public function handle(DynamicLogicService $service): void
    {
        $path  = storage_path('app/dynamic_logic');
        $files = File::files($path);

        if (empty($files)) {
            $this->info('No files found.');
            return;
        }

        $encrypted = 0;
        $skipped   = 0;

        foreach ($files as $file) {
            $content = File::get($file->getPathname());

            // Skip already-encrypted files (no <?php tag = already encrypted)
            if (!str_contains($content, '<?php')) {
                $skipped++;
                continue;
            }

            File::put($file->getPathname(), $service->encrypt($content));
            $encrypted++;
            $this->line("Encrypted: {$file->getFilename()}");
        }

        $this->info("Done. Encrypted: {$encrypted}, Skipped: {$skipped}");
    }
}
