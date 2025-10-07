@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="relative w-full max-w-7xl bg-white/90 backdrop-blur-md shadow-xl rounded-2xl p-8">

        <!-- Header -->
        <div class="flex items-center justify-center gap-3 mb-8">
            <img src="{{ asset('assets/img/logo-sekolah.png') }}" class="w-14 h-14 object-contain" alt="Logo OSIS">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard EVOTE OSIS</h1>
        </div>

        <!-- Tabs -->
        <div class="flex gap-4 mb-6 border-b pb-2 justify-center flex-wrap">
            <button id="tabRekap" class="px-5 py-2 rounded-lg tab-active font-semibold transition">📊 Rekap Voting</button>
            <button id="tabGenerate" class="px-5 py-2 rounded-lg tab-inactive font-semibold transition">🎫 Generate QR
                Code</button>
            <button id="tabKandidat" class="px-5 py-2 rounded-lg tab-inactive font-semibold transition">👥 Kelola
                Kandidat</button>
        </div>

        <!-- Rekap Voting -->
        <div id="rekapContent" class="tab-content">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Rekapitulasi Voting</h2>
            <div class="overflow-hidden rounded-xl shadow-md border border-gray-200">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-green-600 text-white text-left">
                            <th class="p-3">No</th>
                            <th class="p-3">Nama Kandidat</th>
                            <th class="p-3">Jumlah Suara</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($candidates as $i => $cand)
                            <tr class="hover:bg-green-50">
                                <td class="p-3">{{ $i + 1 }}</td>
                                <td class="p-3">{{ $cand->name }}</td>
                                <td class="p-3 font-semibold text-green-700">{{ $cand->votes_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

       <!-- Generate QR -->
<div id="generateContent" class="tab-content hidden">
    <h2 class="text-xl font-bold mb-6 text-gray-800">Generate QR Code</h2>

    <!-- Form Generate Token -->
    <div class="flex items-center gap-4 mb-8 justify-center flex-wrap">
        <select id="kelas"
            class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none shadow-sm">
            <option value="X-BN-1">X-BN-1</option>
            <option value="X-BN-2">X-BN-2</option>
            <option value="X-TJKT-1">X-TJKT-1</option>
            <option value="X-TJKT-2">X-TJKT-2</option>
        </select>
        <select id="jurusan"
            class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none shadow-sm">
            <option value="BN">Busana</option>
            <option value="TJKT">TJKT</option>
            <option value="TO">TO</option>
        </select>
        <input type="number" id="jumlah" placeholder="Masukkan jumlah (misal: 300)"
            class="w-72 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none text-center shadow-sm">
        <button id="generateBtn"
            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow-lg transition">Generate</button>
    </div>

    <!-- Container hasil QR -->
    <div id="qrContainer" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 mb-6 justify-items-center"></div>

    <div class="text-center">
        <button onclick="window.print()" id="printBtn"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-lg transition hidden">
            🖨️ Cetak / Simpan PDF
        </button>
    </div>

    <!-- === CETAK QR BERDASARKAN KELAS === -->
    <div class="mt-10 text-center border-t pt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Cetak QR Berdasarkan Kelas</h3>
        <div class="flex justify-center items-center gap-4 flex-wrap">
            <select id="kelasCetak"
                class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none shadow-sm">
                <option value="X-BN-1">X-BN-1</option>
                <option value="X-BN-2">X-BN-2</option>
                <option value="X-TJKT-1">X-TJKT-1</option>
                <option value="X-TJKT-2">X-TJKT-2</option>
            </select>
            <button id="cetakKelasBtn"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-lg transition">
                🖨️ Cetak QR Kelas
            </button>
        </div>
    </div>
</div>



        <!-- Kandidat Management -->
        <div id="kandidatContent" class="tab-content hidden">
            <h2 class="text-xl font-bold mb-6 text-gray-800">Kelola Kandidat / Paslon</h2>

            <!-- Form Tambah Kandidat -->
            <form id="kandidatForm" class="flex flex-col gap-4 mb-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <input type="text" id="namaKandidat" placeholder="Nama Kandidat"
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none shadow-sm"
                        required>
                    <input type="file" id="fotoKandidat" accept="image/*"
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none shadow-sm">
                </div>
                <input type="text" id="visiKandidat" placeholder="Visi Kandidat"
                    class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none shadow-sm"
                    required>
                <textarea id="misiKandidat" placeholder="Misi Kandidat (pisahkan dengan enter)"
                    class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none shadow-sm"
                    rows="3" required></textarea>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow-lg transition self-start">
                    ➕ Tambah
                </button>
            </form>

            <!-- Tabel Kandidat -->
            <div class="overflow-hidden rounded-xl shadow-md border border-gray-200">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-green-600 text-white text-left">
                            <th class="p-3">No</th>
                            <th class="p-3">Foto</th>
                            <th class="p-3">Nama</th>
                            <th class="p-3">Visi</th>
                            <th class="p-3">Misi</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="kandidatTable" class="divide-y divide-gray-200">
                        @foreach ($candidates as $i => $c)
                            <tr data-id="{{ $c->id }}">
                                <td class="p-3">{{ $i + 1 }}</td>
                                <td class="p-3">
                                    <img src="{{ $c->photo ? asset('storage/' . $c->photo) : asset('assets/img/placeholder.png') }}"
                                        class="w-16 h-16 object-cover rounded-lg">
                                </td>
                                <td class="p-3 font-semibold">{{ $c->name }}</td>
                                <td class="p-3">{{ $c->visi }}</td>
                                <td class="p-3">
                                    <ul class="list-disc pl-4 space-y-1 text-sm">
                                        @foreach (explode("\n", $c->misi) as $misi)
                                            <li>{{ $misi }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="p-3">
                                    <button
                                        class="hapusKandidatBtn px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Tabs
            const tabs = ['rekap', 'generate', 'kandidat'];
            tabs.forEach(tab => {
                document.getElementById('tab' + tab.charAt(0).toUpperCase() + tab.slice(1))
                    .addEventListener('click', () => showTab(tab));
            });

            function showTab(tab) {
                tabs.forEach(t => {
                    document.getElementById(t + 'Content').classList.add('hidden');
                    const btn = document.getElementById('tab' + t.charAt(0).toUpperCase() + t.slice(1));
                    btn.classList.remove('tab-active');
                    btn.classList.add('tab-inactive');
                });
                document.getElementById(tab + 'Content').classList.remove('hidden');
                const activeBtn = document.getElementById('tab' + tab.charAt(0).toUpperCase() + tab.slice(1));
                activeBtn.classList.add('tab-active');
                activeBtn.classList.remove('tab-inactive');
            }

            // Tambah Kandidat via AJAX
            const kandidatForm = document.getElementById("kandidatForm");
            const kandidatTable = document.getElementById("kandidatTable");

            kandidatForm.addEventListener("submit", async (e) => {
                e.preventDefault();
                const formData = new FormData();
                formData.append('name', document.getElementById("namaKandidat").value);
                formData.append('visi', document.getElementById("visiKandidat").value);
                formData.append('misi', document.getElementById("misiKandidat").value);

                const fotoInput = document.getElementById("fotoKandidat");
                if (fotoInput.files[0]) formData.append('photo', fotoInput.files[0]);

                try {
                    const res = await fetch('/candidate', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    });
                    const data = await res.json();
                    if (data.success) {
                        addKandidatRow(data.kandidat);
                        kandidatForm.reset();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Kandidat berhasil ditambahkan',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Kandidat gagal ditambahkan'
                        });
                    }
                } catch (err) {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Cek console untuk detail error'
                    });
                }
            });

            function addKandidatRow(kandidat) {
                const tr = document.createElement('tr');
                tr.dataset.id = kandidat.id;
                tr.innerHTML = `
            <td class="p-3"></td>
            <td class="p-3"><img src="${kandidat.foto_url || '{{ asset('assets/img/placeholder.png') }}'}" class="w-16 h-16 object-cover rounded-lg"></td>
            <td class="p-3 font-semibold">${kandidat.name}</td>
            <td class="p-3">${kandidat.visi}</td>
            <td class="p-3">
                <ul class="list-disc pl-4 space-y-1 text-sm">
                    ${kandidat.misi.split("\n").map(m => `<li>${m}</li>`).join("")}
                </ul>
            </td>
            <td class="p-3">
                <button class="hapusKandidatBtn px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Hapus</button>
            </td>
        `;
                kandidatTable.appendChild(tr);
                updateRowNumbers();
                tr.querySelector('.hapusKandidatBtn').addEventListener('click', () => deleteKandidat(tr.dataset.id,
                    tr));
            }

            function updateRowNumbers() {
                kandidatTable.querySelectorAll('tr').forEach((tr, i) => {
                    tr.querySelector('td:first-child').textContent = i + 1;
                });
            }

            // Hapus kandidat
            document.querySelectorAll('.hapusKandidatBtn').forEach(btn => {
                const tr = btn.closest('tr');
                btn.addEventListener('click', () => deleteKandidat(tr.dataset.id, tr));
            });

            async function deleteKandidat(id, tr) {
                const result = await Swal.fire({
                    title: 'Yakin?',
                    text: "Kandidat ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                });

                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`/delete-candidate/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        });
                        const data = await res.json();
                        if (data.message === "Kandidat berhasil dihapus") {
                            tr.remove();
                            updateRowNumbers();
                            Swal.fire({
                                icon: 'success',
                                title: 'Dihapus!',
                                text: 'Kandidat berhasil dihapus',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Kandidat gagal dihapus'
                            });
                        }
                    } catch (err) {
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Cek console untuk detail error'
                        });
                    }
                }
            }

            // === GENERATE TOKEN SECTION ===
const generateBtn = document.getElementById("generateBtn");
const qrContainer = document.getElementById("qrContainer");

if (generateBtn) {
    generateBtn.addEventListener("click", async () => {
        const kelas = document.getElementById("kelas").value;
        const jurusan = document.getElementById("jurusan").value;
        const jumlah = document.getElementById("jumlah").value;

        if (!kelas || !jurusan || !jumlah || jumlah <= 0) {
            Swal.fire({
                icon: "warning",
                title: "Input tidak lengkap",
                text: "Harap isi semua data (kelas, jurusan, dan jumlah)",
            });
            return;
        }

        try {
            const res = await fetch("/generate-token", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ kelas, jurusan, jumlah })
            });

            if (!res.ok) throw new Error(`HTTP ${res.status}`);

            const tokens = await res.json();
            qrContainer.innerHTML = "";

            tokens.forEach(t => {
    const card = document.createElement("div");
    card.className =
        "bg-white shadow-md rounded-xl p-4 flex flex-col items-center justify-center border border-gray-200 hover:shadow-lg transition";

    const qr = document.createElement("div");
   // QR code akan berisi URL lengkap, bukan token mentah
new QRCode(qr, { text: t.url, width: 120, height: 120 });


    const p = document.createElement("p");
    p.className = "text-xs mt-3 break-all text-center text-gray-700 font-mono";
    p.textContent = t.token;

    card.appendChild(qr);   
    card.appendChild(p);
    qrContainer.appendChild(card);
});
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "Token berhasil digenerate",
                timer: 1500,
                showConfirmButton: false
            });
        } catch (err) {
            console.error(err);
            Swal.fire({
                icon: "error",
                title: "Gagal",
                text: "Terjadi kesalahan saat generate token"
            });
        }
    });
}

// === CETAK QR PER KELAS ===
const cetakKelasBtn = document.getElementById("cetakKelasBtn");
if (cetakKelasBtn) {
    cetakKelasBtn.addEventListener("click", () => {
        const kelas = document.getElementById("kelasCetak").value;
        window.open(`/qr-pdf/${kelas}`, "_blank");
    });
}

        });
    </script>
@endpush
