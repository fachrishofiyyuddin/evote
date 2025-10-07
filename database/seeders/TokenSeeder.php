<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Token;
use Illuminate\Support\Facades\DB;

class TokenSeeder extends Seeder
{
    public function run()
    {
        // Hapus semua token lama
        Token::query()->delete();
        DB::statement('ALTER TABLE tokens AUTO_INCREMENT = 1');

        $tokens = [
            ['token' => 'EVOTE-OSIS-2025-X-BN-1-ABCDE-01', 'kelas' => 'X-BN-1', 'jurusan' => 'BN', 'used' => false],
            ['token' => 'EVOTE-OSIS-2025-X-BN-1-FGHIJ-02', 'kelas' => 'X-BN-1', 'jurusan' => 'BN', 'used' => false],
            ['token' => 'EVOTE-OSIS-2025-X-TJKT-1-KLMNO-01', 'kelas' => 'X-TJKT-1', 'jurusan' => 'TJKT', 'used' => false],
            ['token' => 'EVOTE-OSIS-2025-X-TJKT-1-PQRST-02', 'kelas' => 'X-TJKT-1', 'jurusan' => 'TJKT', 'used' => false],
            ['token' => 'EVOTE-OSIS-2025-X-TO-1-UVWXY-01', 'kelas' => 'X-TO-1', 'jurusan' => 'TO', 'used' => false],
        ];

        foreach ($tokens as $tok) {
            Token::create($tok);
        }
    }
}
