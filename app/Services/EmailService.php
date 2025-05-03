<?php

namespace App\Services;

use App\Models\KelasWbModel;
use App\Models\KelasMataPelajaranModel;
use App\Models\PpdbModel;
use App\Models\EkstrakurikulerModel;
use App\Models\NilaiKegiatanModel;
use DB;
use Log;

/**
 * 
 */
class EmailService
{
    function __construct()
    {
        
    }

    public function sendInvoice(array $data = [], array $receiver = [])
    {
        /**
         * 
         * receiver = [
         *  'email' => ''
         *  'name'  => ''
         * ]
         */

        $data = [
            'nama' => 'test',
            'nik' => '11',
            'rbiayadaftar' => '1000000',
            'rbiayadaftar' => '1000000',
            'klk' => '1000000',
            'kp' => '1000000',
            'rbiaya' => '1000000',
            'rbiayaspp' => '1000000',
            'sis' => '1000000',
            'rwakaf' => '1000000',
            'rinfaq' => '1000000',
            'daf' => '1000000',
            'sis' => '1000000',
            'dep' => '1000000',
            'sed' => '1000000',
            'total' => '1000000',
        ];

        \Mail::send("mails.invoice", $data, function($message) use ($receiver) {

            Log::debug(config('app.name').' | Invoice');
            Log::debug(json_encode($receiver));
            Log::debug(config('mail.from.address').' - '.config('mail.from.name'));
            
            $message->to($receiver['email'], $receiver['name'])
                    ->subject(config('app.name').' | Invoice');
            $message->from(config('mail.from.address'), config('mail.from.name'));
        });
    }

}