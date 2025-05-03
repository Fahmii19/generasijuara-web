<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class SetSessionDBCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:set-session {--key=} {--value=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Set Session DB';

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
     * @return int
     */
    public function handle()
    {
        $this->info('--start--');
        $key = !empty($this->option('key')) ? $this->option('key') : null;
        $value = !empty($this->option('value')) ? $this->option('value') : null;
        $this->line('key: '.$key);
        $this->line('value: '.$value);

        if (empty($key) || empty($value)) {
            $this->error('key or value error');
            return 0;
        }
        DB::statement("SET SESSION ".$key." = '".$value."'");
        $this->info('--end--');
        return 0;
    }
}
