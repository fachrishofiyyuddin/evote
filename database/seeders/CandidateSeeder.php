<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidate;
use Illuminate\Support\Facades\DB;

class CandidateSeeder extends Seeder
{
    public function run()
    {
        // Hapus semua data lama, reset auto-increment
        Candidate::query()->delete();
        DB::statement('ALTER TABLE candidates AUTO_INCREMENT = 1');

        $candidates = [
            [
                'name' => 'Anisa Putri',
                'photo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=300&auto=format&fit=crop',
                'visi' => 'Bersama kita ciptakan OSIS yang lebih baik',
                'misi' => json_encode([
                    'Meningkatkan kedisiplinan siswa',
                    'Meningkatkan kegiatan ekstrakurikuler',
                    'Menciptakan lingkungan sekolah yang nyaman'
                ])
            ],
            [
                'name' => 'Budi Santoso',
                'photo' => 'https://images.unsplash.com/photo-1545996124-1b2bdf2a1a88?q=80&w=300&auto=format&fit=crop',
                'visi' => 'Mewujudkan OSIS yang berkualitas',
                'misi' => json_encode([
                    'Meningkatkan partisipasi siswa dalam OSIS',
                    'Meningkatkan program sosial dan lingkungan',
                    'Memperkuat komunikasi antar siswa dan guru'
                ])
            ],
            [
                'name' => 'Citra Lestari',
                'photo' => 'https://images.unsplash.com/photo-1607746882042-944635dfe10e?q=80&w=300&auto=format&fit=crop',
                'visi' => 'OSIS kreatif dan inovatif',
                'misi' => json_encode([
                    'Membuat program inovatif untuk sekolah',
                    'Mengadakan lomba dan kompetisi',
                    'Mendorong kreativitas siswa'
                ])
            ]
        ];

        foreach ($candidates as $cand) {
            Candidate::create($cand);
        }
    }
}
