<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\TutorModel;
use App\Models\MataPelajaranModel;
use App\Models\User;
use App\Models\UserRoleModel;
use App\Utils\Constant;
use App\Utils\Misc;
use DB;

class TutorImport implements ToCollection
{
    private $startRowIndex;

    public function __construct($startRowIndex = 0)
    {
        $this->startRowIndex = $startRowIndex;
    }

    public function collection(Collection $rows)
    {
        $currentTutor = null;
        foreach ($rows as $key => $row) 
        {
            if ($key < $this->startRowIndex) {
                continue;
            }

            DB::beginTransaction();
            try {
                if (!empty($row[5])) {
                    $currentTutor = [
                        'no' => trim($row[0]),
                        'name' => trim($row[1]),
                        'hp' => trim($row[4]),
                        'email' => trim($row[5]),
                        'status' => trim($row[6]),
                        'nip' => trim($row[7]),
                    ];

                    // check tutor
                    $user = User::where('email', $currentTutor['email'])->first();

                    if (empty($user)) {
                        error_log($currentTutor['email']);
                        $user = User::create([
                            'username' => $currentTutor['email'],
                            'password' => bcrypt($currentTutor['email']),
                            'email' => $currentTutor['email'],
                            'phone' => $currentTutor['hp'],
                            'name' => $currentTutor['name'] ?? $currentTutor['nip'],
                            'is_active' => $currentTutor['status'],
                        ]);

                        $userRole = UserRoleModel::firstOrCreate(
                            ['user_id' => $user->id, 'role_id' => Constant::ROLE_TUTOR_ID]
                        );

                        $tutor = TutorModel::create([
                            'user_id' => $user->id,
                            'nip' => $currentTutor['nip'],
                        ]);
                    }
                }

                // $kelasAmpuh = trim($row[2]);
                // $mapelAmpuh = trim($row[3]);
                
                // // check mapel
                // if (!empty($mapelAmpuh)) {
                //     $mapel = MataPelajaranModel::firstOrCreate(
                //         ['nama' => $mapelAmpuh],
                //         ['is_active' => true]
                //     );
                // }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack(); 
                error_log($e->getMessage());
            }
        }
    }
}
