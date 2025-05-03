<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RoleModel;
use App\Services\UserService;
use DB;
use Constant;

class CreateSuperadminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:superadmin {--username=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create superadmin account command';

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
        try {
            
            DB::beginTransaction();
            
            $username = !empty($this->option('username')) ? $this->option('username') : null;
            $password = !empty($this->option('password')) ? $this->option('password') : 'superadmin123';
            $this->line('username: '.$username);
            $this->line('password: '.$password);

            if (empty($username) || empty($password)) {
                $this->error('username or password error');
                return 0;
            }

            $userService = new UserService();
            $create = $userService->createUser(
                [
                    'name' => $username,
                    'username' => $username,
                    'password' => $password,
                    'is_active' => true,
                ],
                Constant::ROLE_SUPERADMIN_ID
            );

            if ($create['error']) {
                $this->error('failed: '.$create['message']);
                DB::rollBack();
            } else {
                $this->info('success');
                DB::commit();
            }
            
            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('failed: '.$e->getMessage());
            return 0;
        }
    }
}
