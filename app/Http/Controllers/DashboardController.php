<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Token;
use App\Models\Vote;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    // Halaman dashboard admin
    public function index()
    {
        $candidates = Candidate::withCount('votes')->get(); // ambil kandidat + jumlah vote
        return view('dashboard', compact('candidates'));
    }

    // Generate token QR secara bulk
    public function generateToken(Request $request)
    {
        $request->validate([
            'kelas' => 'required|string',
            'jurusan' => 'required|string',
            'jumlah' => 'required|integer|min:1'
        ]);

        $tokens = [];
        for ($i = 1; $i <= $request->jumlah; $i++) {
            $kodeUnik = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
            $nomorUrut = str_pad($i, 2, '0', STR_PAD_LEFT);
            $token = "EVOTE-OSIS-2025-{$request->kelas}-{$kodeUnik}-{$nomorUrut}";

            // Simpan token ke DB
            $tokens[] = Token::create([
                'token' => $token,
                'kelas' => $request->kelas,
                'jurusan' => $request->jurusan
            ]);
        }

        return response()->json($tokens);
    }

    // Tambah kandidat baru
    public function addCandidate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'foto' => 'nullable|image|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('candidates', 'public');
        }

        $candidate = Candidate::create([
            'name' => $request->name,
            'visi' => $request->visi,
            'misi' => $request->misi,
            'photo' => $path
        ]);

        return response()->json([
            'success' => true,
            'kandidat' => [
                'id' => $candidate->id,
                'name' => $candidate->name,
                'visi' => $candidate->visi,
                'misi' => $candidate->misi,
                'foto_url' => $candidate->photo ? asset('storage/' . $candidate->photo) : null
            ]
        ]);
    }

    // Hapus kandidat
    public function deleteCandidate($id)
    {
        $candidate = Candidate::findOrFail($id);
        if ($candidate->photo) {
            Storage::disk('public')->delete($candidate->photo);
        }
        $candidate->delete();

        return response()->json(['message' => 'Kandidat berhasil dihapus']);
    }
}
