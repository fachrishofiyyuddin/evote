@extends('layouts.app')

@section('title', 'Rekap Voting')

@section('content')
    <main class="max-w-7xl mx-auto mt-16 p-8 bg-white/90 backdrop-blur-md rounded-3xl shadow-xl">
        <h1 class="text-4xl sm:text-5xl font-bold text-center mb-12 text-green-700">📊 Live Rekap Voting OSIS</h1>

        <div id="candidatesContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @foreach ($candidates as $index => $c)
                <div data-id="{{ $c->id }}"
                    class="candidate-card relative bg-white rounded-3xl shadow-lg p-8 flex flex-col items-center transition transform hover:scale-105 hover:shadow-2xl">

                    <!-- Nomor paslon besar di pojok kiri atas -->
                    <div
                        class="absolute -top-5 -left-5 bg-green-600 text-white font-extrabold rounded-full w-16 h-16 sm:w-20 sm:h-20 flex items-center justify-center text-3xl sm:text-4xl shadow-xl border-2 border-white">
                        {{ $index + 1 }}
                    </div>

                    <!-- Foto kandidat lebih besar -->
                    <div class="relative w-40 h-40 sm:w-48 sm:h-48 mb-6">
                        <img src="{{ $c->photo ? asset('storage/' . $c->photo) : asset('assets/img/placeholder.png') }}"
                            class="w-full h-full rounded-full object-cover border-4 border-green-500">
                    </div>

                    <!-- Nama kandidat -->
                    <h2 class="font-bold text-3xl sm:text-4xl text-slate-800 mb-4 text-center">{{ $c->name }}</h2>

                    <!-- Votes count besar di tengah -->
                    <div class="votes-count text-6xl sm:text-7xl font-extrabold text-green-700 mb-2">{{ $c->votes_count }}
                    </div>
                    <div class="text-2xl sm:text-3xl font-semibold text-slate-600">Suara</div>
                </div>
            @endforeach
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        const candidatesContainer = document.getElementById('candidatesContainer');

        function updateCandidates(candidates) {
            candidates.forEach((c, index) => {
                const card = candidatesContainer.querySelector(`.candidate-card[data-id='${c.id}']`);
                if (card) {
                    const votesCount = card.querySelector('.votes-count');
                    votesCount.textContent = c.votes_count;
                }
            });
        }

        // Polling update votes setiap 3 detik
        async function fetchVotes() {
            try {
                const res = await fetch('{{ route('api.votes') }}');
                const data = await res.json();
                updateCandidates(data);
            } catch (err) {
                console.error('Error fetching votes:', err);
            }
        }

        setInterval(fetchVotes, 3000);
    </script>
@endpush
