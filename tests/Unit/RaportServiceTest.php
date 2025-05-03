<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\RaportService;

class RaportServiceTest extends TestCase
{
    private $raportService = null;
    protected function setUp(): void
    {
        parent::setUp();
        $this->raportService = new RaportService();
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_konversi_tingkatan()
    {
        // Provide valid input

        $loop = 0;
        for ($kelas=1; $kelas <= 12; $kelas++) { 
            for ($smt=1; $smt <= 2 ; $smt++) { 
                // Call the function
                $result = $this->raportService->konversiKelasInfo($kelas, $smt);
                
                // $this->assertEquals($results[$loop], $result);
                $loop++;
            }
        }
        
        
    }
}
