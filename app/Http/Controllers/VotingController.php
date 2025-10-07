<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Token;
use App\Models\Vote;

class VotingController extends Controller
{
    // Halaman scan QR
    public function scan()
    {
        return view('scan');
    }

    public function rekap()
    {
        $candidates = Candidate::withCount('votes')->get(); // asumsi ada relasi votes
        return view('rekap', compact('candidates'));
    }

    // API untuk live update suara
    public function apiVotes()
    {
        // Ambil semua kandidat beserta jumlah votes
        $candidates = Candidate::withCount('votes')->get();

        // Hitung total votes untuk persentase
        $totalVotes = $candidates->sum('votes_count') ?: 1; // biar nggak div/0

        $data = $candidates->map(function ($c, $index) use ($totalVotes) {
            return [
                'id' => $c->id,
                'no' => $index + 1, // nomor kandidat / paslon
                'name' => $c->name,
                'photo' => $c->photo ? asset('storage/' . $c->photo) : asset('assets/img/placeholder.png'),
                'votes_count' => $c->votes_count,
                'percentage' => round(($c->votes_count / $totalVotes) * 100, 1) // persentase suara
            ];
        });

        return response()->json($data);
    }


    // Halaman vote berdasarkan token
    public function vote(Request $request, $token)
    {
        $tokenData = Token::where('token', $token)->firstOrFail();
        $candidates = Candidate::all();

        // Cek apakah token sudah digunakan
        $alreadyUsed = $tokenData->used;

        return view('vote', compact('candidates', 'tokenData', 'alreadyUsed'));
    }

    // Submit vote
    public function submitVote(Request $request)
    {
        $request->validate([
            'token_id' => 'required|exists:tokens,id',
            'candidate_id' => 'required|exists:candidates,id'
        ]);

        $token = Token::findOrFail($request->token_id);

        if ($token->used) {
            return response()->json(['message' => 'Token sudah digunakan'], 422);
        }

        Vote::create([
            'candidate_id' => $request->candidate_id,
            'token_id' => $token->id
        ]);

        $token->used = true;
        $token->save();

        return response()->json(['message' => 'Vote berhasil']);
    }
}
