<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\KirimEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\AlumniModel;

// use log
use Illuminate\Support\Facades\Log;

class SialumController extends Controller
{
    public function add(Request $request, $id = null)
    {
        $alumni = $id ? AlumniModel::find($id) : new AlumniModel();
        return view('alumni.add', compact('alumni'));
    }
    // app/Http/Controllers/Web/SialumController.php

    public function store(Request $request)
    {
        set_time_limit(300); // Set timeout 5 menit
        $validated = $request->validate([
            'nis' => 'required',
            'nisn' => 'required',
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
        ]);

        try {
            Mail::to($request->email)
                ->cc('rahmat@generasijuara.sch.id')
                ->send(new KirimEmail($validated));

            return response()->json([
                'success' => true,
                'message' => 'Data alumni berhasil disimpan dan email konfirmasi telah dikirim'
            ]);
        } catch (\Exception $e) {
            Log::error('Email error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Data berhasil disimpan tetapi gagal mengirim email: ' . $e->getMessage()
            ], 500);
        }
    }
}
