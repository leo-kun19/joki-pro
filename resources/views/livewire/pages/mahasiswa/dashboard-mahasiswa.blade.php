<div>
    {{-- <livewire:pages.mahasiswa.components.navbar-mahasiswa> --}}
        <div class="rounded-md p-4">
            <div class="grid grid-cols-1 gap-2 rounded-md bg-white p-2 md:grid-cols-4">
                @foreach ($pembelajaran as $p)
                    <a class="flex  cursor-pointer justify-center rounded-md bg-emerald-400 px-2 py-1 uppercase text-white shadow-md hover:bg-emerald-500"
                        href="{{ route('pembelajaran.dashboard', $p->code) }}">{{ $p->nama }}</a>
                @endforeach

            </div>
        </div>
</div>
