<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlumniModel;
use Illuminate\Support\Facades\Log;
use App\Mail\KirimEmail;
use Illuminate\Support\Facades\Mail;

class SialumController extends Controller
{
    public function add(Request $request, $id = null)
    {
        $alumni = new AlumniModel();
        return view('alumni.add', compact('alumni'));
    }

    public function store(Request $request)
    {
        set_time_limit(300);

        try {
            // Buat record alumni baru
            $alumni = AlumniModel::create($request->all());

            // Kirim email
            Mail::to($request->email)
                ->cc('fahmitb70@gmail.com')
                ->send(new KirimEmail($alumni->toArray()));

            return response()->json([
                'success' => true,
                'message' => 'Data alumni berhasil disimpan dan email konfirmasi telah dikirim',
                'data' => $alumni
            ]);
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());

            // Cek jika error berasal dari pengiriman email
            $errorMessage = str_contains($e->getMessage(), 'Mail')
                ? 'Data berhasil disimpan tetapi gagal mengirim email: ' . $e->getMessage()
                : 'Gagal menyimpan data: ' . $e->getMessage();

            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 500);
        }
    }
}
