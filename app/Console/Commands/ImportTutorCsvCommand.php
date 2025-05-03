<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Utils\Misc;
use App\Utils\Constant;

use App\Models\User;
use App\Models\TutorModel;
use App\Models\UserRoleModel;

use DB;

class ImportTutorCsvCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:tutor-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        DB::beginTransaction();

        try {
            $this->line('---START PROCESS---');

            // path = /import/rombel/2021/HST-GANJIL.csv
            $path = '/import/data_tutor.csv';
            $delimiter = ',';
            $this->line('path: '.$path);
            $this->line('delimiter: '.$delimiter);

            $rows = Misc::csvReader($path, $delimiter);
            foreach ($rows as $key => $row) {
                $this->info('row: '.($key+1).'/'.count($rows));
                $tempIndex = 0;
                $no = $row[$tempIndex++];
                $nama = $row[$tempIndex++];
                $hp = $row[$tempIndex++];
                $email = $row[$tempIndex++];
                $status = $row[$tempIndex++];
                $nip = $row[$tempIndex++];

                $this->line('no: '.$no);
                $this->line('nama: '.$nama);
                $this->line('hp: '.$hp);
                $this->line('email: '.$email);
                $this->line('status: '.$status);
                $this->line('nip: '.$nip);

                $user = User::where('email', $email)->first();

                if (empty($user)) {
                    $this->info('user create...');
                    $user = User::create([
                        'username' => $email,
                        'password' => bcrypt($email),
                        'email' => $email,
                        'phone' => $hp,
                        'name' => !empty($nama) ? $nama : $nip,
                        'is_active' => true,
                    ]);

                    $user_role = UserRoleModel::where('user_id', $user->id)
                        ->where('role_id', Constant::ROLE_TUTOR_ID)
                        ->first();

                    if (empty($user_role)) {

                        $this->info('user role create...');
                        $user_role = UserRoleModel::create([
                            'user_id' => $user->id,
                            'role_id' => Constant::ROLE_TUTOR_ID,
                        ]);
                    }else{
                        $this->danger('user role exist...');
                    }

                    $this->info('tutor create...');
                    $tutor = TutorModel::create([
                        'user_id' => $user->id,
                        'nip' => $nip,
                    ]);
                }
                $this->line('-----');
            }
            DB::commit();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            DB::rollBack();
        }

        $this->info('---END PROCESS---');
        return 0;
    }
}
