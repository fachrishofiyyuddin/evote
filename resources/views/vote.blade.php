@extends('layouts.app')

@section('title', 'E-Voting Ketua OSIS')

@section('content')
    <main
        class="w-full max-w-5xl bg-white/90 rounded-2xl shadow-lg p-4 sm:p-6 md:p-8 
         mt-16 mb-16 sm:mt-8 sm:mb-8 mx-auto">
        <header class="mb-8 text-center text-slate-800">
            <img src="{{ asset('assets/img/logo-sekolah.png') }}" alt="Logo Sekolah"
                class="mx-auto mb-4 w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 object-contain mt-4 mb-4" />
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-semibold">E-Voting Ketua OSIS</h1>
            <p class="mt-2 text-sm sm:text-base md:text-lg text-slate-600">
                Silakan pilih salah satu kandidat. Token:
                <span id="tokenLabel" class="font-medium">{{ $tokenData->token }}</span>
            </p>
        </header>

        <form id="voteForm" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 md:gap-8 justify-center">
        </form>
    </main>
@endsection

@push('scripts')
    <script>
        const CANDIDATES = [
            @foreach ($candidates as $index => $c)
                {
                    id: '{{ $c->id }}',
                    number: '{{ $index + 1 }}',
                    name: '{{ $c->name }}',
                    slogan: '{{ $c->visi }}',
                    photo: '{{ $c->photo ? asset('storage/' . $c->photo) : asset('assets/img/placeholder.png') }}'
                },
            @endforeach
        ];

        const token = '{{ $tokenData->token }}';
        const tokenId = '{{ $tokenData->id }}';
        const alreadyVoted = {{ $alreadyUsed ? 'true' : 'false' }};
        const wrap = document.querySelector('#voteForm');

        function disableVoting() {
            wrap.classList.add('opacity-60', 'pointer-events-none');
        }

        function renderCandidates() {
            wrap.innerHTML = '';

            CANDIDATES.forEach(c => {
                const label = document.createElement('label');
                label.className =
                    'candidate-card bg-white rounded-2xl p-4 sm:p-5 md:p-6 flex flex-col items-center gap-3 shadow-lg cursor-pointer hover:shadow-2xl transition-all relative';
                label.innerHTML = `
                <div class="absolute -top-3 -left-3 bg-green-500 text-white font-extrabold rounded-full w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center text-lg sm:text-xl shadow border-2 border-white">
                    ${c.number}
                </div>
                <img src="${c.photo}" alt="Foto ${c.name}" 
                     class="w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 rounded-full object-cover border-2 border-green-600" />
                <div class="text-center mt-2">
                    <div class="text-lg sm:text-xl md:text-xl font-semibold text-slate-800">${c.name}</div>
                    <div class="mt-1 text-xs sm:text-sm md:text-sm text-slate-500 italic">${c.slogan}</div>
                </div>
                <input type="radio" name="candidate_id" value="${c.id}" class="mt-2" />
            `;
                wrap.appendChild(label);
            });

            wrap.addEventListener('change', async e => {
                if (e.target.name === 'candidate_id') {
                    const chosen = CANDIDATES.find(c => c.id === e.target.value);

                    if (alreadyVoted) {
                        Swal.fire('Token sudah digunakan', 'Kamu tidak bisa memilih lagi.', 'error');
                        return;
                    }

                    const result = await Swal.fire({
                        title: 'Anda yakin?',
                        text: `Memilih ${chosen.name}. Pilihan tidak dapat diubah!`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#15a34b',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, pilih'
                    });

                    if (result.isConfirmed) {
                        try {
                            const res = await fetch('{{ route('vote.submit') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    token_id: tokenId,
                                    candidate_id: chosen.id
                                })
                            });

                            if (!res.ok) throw new Error('Vote gagal terkirim');

                            const data = await res.json();

                            disableVoting();

                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonColor: '#15a34b'
                            }).then(() => {
                                // Redirect ke homepage setelah menutup Swal
                                window.location.href = '/';
                            });
                        } catch (err) {
                            console.error(err);
                            Swal.fire('Error', 'Vote gagal terkirim, coba lagi.', 'error');
                        }
                    }
                }
            });

            if (alreadyVoted) {
                disableVoting();
                Swal.fire('Token sudah digunakan', 'Hasil sudah tercatat.', 'info');
            }
        }

        renderCandidates();
    </script>
@endpush
