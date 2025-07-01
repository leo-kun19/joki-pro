<div x-data="{ sidebarIsOpen: false, sidebarMateri: false }" class="fixed flex w-full flex-col md:flex-row">
    <!-- This allows screen readers to skip the sidebar and go directly to the main content. -->
    <a class="sr-only" href="#main-content">skip to the main content</a>
    <div wire:target="kirim_semua_jawaban" wire:loading class="bg-slate-500/40 absolute z-50 inset-0 flex justify-center items-center">Loading...</div>
    <!-- dark overlay for when the sidebar is open on smaller screens  -->
    <div x-cloak x-show="sidebarIsOpen" class="fixed inset-0 z-20 bg-slate-900/10 backdrop-blur-xs md:hidden"
        aria-hidden="true" x-on:click="sidebarIsOpen = false" x-transition.opacity></div>
    <div x-cloak x-show="sidebarMateri" class="fixed inset-0 z-10 bg-slate-900/10 backdrop-blur-xs md:hidden"
        aria-hidden="true" x-on:click="sidebarMateri = false" x-transition.opacity></div>
    <livewire:pages.mahasiswa.components.sidebar-pertemuan :code_pembelajaran="$code_pembelajaran" />

    <!-- top navbar & main content  -->
    <div class="h-svh w-full overflow-y-auto bg-white dark:bg-slate-900">
        <!-- top navbar  -->
        <livewire:pages.mahasiswa.components.navbar-materi :code_pembelajaran="$code_pembelajaran" />
        <!-- main content  -->
        <div id="main-content" class="p-4">
            <div class="overflow-y-auto">
                <div x-data="{
                    jam: $persist(0),
                    menit: $persist(0),
                    detik: $persist(20),
                    isLoad: $persist(false),
                    start_timer() {
                        $wire.dispatch('close-modal', 'popup-konfirmasi')
                        if (!this.isLoad) {
                            this.jam = $wire.jam
                            this.menit = $wire.menit
                            this.detik = $wire.detik
                            this.isLoad = true
                        }
                
                
                        var total = this.jam * 3600 + this.menit * 60 + this.detik;
                        setInterval(() => {
                            total--
                            if (total > 0) {
                                var jam = Math.floor(total / 3600)
                                var menit = Math.floor((total / 60) - (jam * 60))
                                var detik = total - ((jam * 3600) + (menit * 60))
                                var jamFix = jam < 10 ? `0${jam}` : jam
                                var menitFix = menit < 10 ? `0${menit}` : menit
                                var detikFix = detik < 10 ? `0${detik}` : detik
                
                                this.jam = jamFix
                                this.menit = menitFix
                                this.detik = detikFix
                
                            } else {
                                $wire.kirim_semua_jawaban()
                                this.isLoad = false
                            }
                        }, 1000)
                    }
                }">
                    <div class="flex flex-row text-sm ">
                        <div
                            class="flex w-full flex-col gap-4 rounded-md border border-gray-200 p-4 dark:border-gray-700 ">
                            @foreach ($main_soals as $value)
                                @if ($value->index)
                                    <div class="rounded-md bg-white p-2 text-xl font-bold">{{ $value->index }}.
                                        {{ $value->judul }}</div>
                                    @if ($value->konten)
                                        <div class="prose text-sm rounded-md border border-dashed bg-white p-2">
                                            <div class="konten-mahasiswa">{!! $value->konten !!}</div>

                                        </div>
                                    @endif
                                @endif
                                <ul class="flex list-decimal flex-col gap-3 rounded-md bg-white p-2 pl-5 md:pl-8">
                                    @foreach ($value->soals as $soal)
                                        <li class="prose text-sm">{!! $soal->pertanyaan !!}</li>

                                        {{-- Jika is_sharing, langsung tampilkan kunci jawaban --}}
                                        @if ($is_sharing)
                                            <div class="flex flex-col rounded-md border border-dashed p-2 mt-2">
                                                <p class="border-b text-sm font-semibold">Kunci Jawaban</p>
                                                @if (!empty($soal->kunci_jawaban))
                                                    <div class="mt-2 prose">{!! $soal->kunci_jawaban !!}</div>
                                                @else
                                                    <div class="text-red-500 text-sm mt-2">Kunci jawaban tidak tersedia
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        @if ($soal->type_soal == 'ganda')
                                            <ul>
                                                @foreach ($soal->pilihan_jawabans as $option)
                                                    <li class="flex flex-row items-center gap-2 cursor-pointer">
                                                        <input name="{{ $soal->id }}" type="radio"
                                                            value="{{ $option->id }}"
                                                            wire:model="pilihan_jawaban.{{ $soal->id }}.pilihan_id">
                                                        <span>{{ $option->index }}</span>.
                                                        <span>{!! $option->jawaban !!}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @if ($master_fix == false)
                                                @if (isset($pilihan_jawaban[$soal->id]))
                                                    <div class="w-full cursor-pointer rounded-md bg-yellow-400 px-2 py-1 text-center text-white hover:bg-yellow-500 md:w-24"
                                                        wire:click='send_id_soal_update({{ $soal->id }},1)'>
                                                        Ganti
                                                    </div>
                                                @else
                                                    <div class="w-full cursor-pointer rounded-md bg-emerald-400 px-2 py-1 text-center text-white hover:bg-emerald-500 md:w-24"
                                                        wire:click='send_id_soal({{ $soal->id }},1)'>
                                                        Pilih
                                                    </div>
                                                @endif
                                            @else
                                                @foreach ($jawaban_fixs[$soal->id] as $jawaban)
                                                    <div class="flex flex-row items-center gap-2">
                                                        @if ($jawaban['is_correct'])
                                                            <div
                                                                class=" flex flex-col p-2 rounded-md border items-center">
                                                                @if ($jawaban['is_true'])
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor"
                                                                        class="size-6 text-green-500">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="m4.5 12.75 6 6 9-13.5" />
                                                                    </svg>
                                                                @else
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor"
                                                                        class="size-6 text-red-500">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M6 18 18 6M6 6l12 12" />
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        <div class="flex flex-col rounded-md border border-dashed p-2">
                                                            <p class="border-b text-sm "> Jawaban anda
                                                            <p>
                                                                @if ($jawaban['jawaban'] == '')
                                                                    <div class="text-red-500">Tidak ada jawaban</div>
                                                                @else
                                                                    <div class="text-sm mt-2">{!! $jawaban['jawaban'] !!}
                                                                    </div>
                                                                @endif
                                                        </div>
                                                    </div>

                                                    @if ($jawaban->is_fix)
                                                        <div class="flex flex-col rounded-md border border-dashed p-2">
                                                            <p class="border-b text-sm "> Kunci Jawaban
                                                            <p>
                                                                @if ($soal->kunci_jawaban)
                                                                    <div class="text-red-500 text-sm mt-2">Kunci jawaban
                                                                        tidak tersedia</div>
                                                                @else
                                                                    <div class="text-sm mt-2">{!! $soal->kunci_jawaban !!}
                                                                    </div>
                                                                @endif
                                                        </div>
                                                        @if ($jawaban->is_correct)
                                                            <div class="flex flex-row items-center gap-2">
                                                                <div
                                                                    class=" flex flex-col p-2 rounded-md border items-center">
                                                                    <p class="border-b text-sm "> Bobot nilai
                                                                    <p>
                                                                    <p class="font-bold text-sm mt-2">
                                                                        {{ $jawaban['bobot_nilai'] }}</p>
                                                                </div>
                                                                <div
                                                                    class="rounded-md border border-yellow-400 border-dashed p-2 ">
                                                                    <p class="border-b text-sm "> Feedback dosen
                                                                    <p>
                                                                    <div class="text-sm font-bold mt-2">
                                                                        {!! $jawaban['feedback_dosen'] ?? 'Tidak ada Feedback Dosen' !!}</div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        @else
                                            @if ($master_fix == false)
                                                <div class="flex flex-col gap-2">
                                                    @foreach (range(1, $soal->qty_jawaban) as $index_jawaban)
                                                        @if (isset($jawabans[$soal->id][$index_jawaban]))
                                                            <div class="rounded-md border border-dashed p-2">

                                                                <div class="text-sm mt-2">{!! $jawabans[$soal->id][$index_jawaban] !!}</div>

                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="flex flex-row gap-2">


                                                    @foreach (range(1, $soal->qty_jawaban) as $index_jawaban)
                                                        @php
                                                            // Cek apakah jawaban untuk soal ini dan index_jawaban sudah is_fix
                                                            $jawaban_fix = collect($jawaban_all)->first(function (
                                                                $jawaban,
                                                            ) use ($soal, $index_jawaban) {
                                                                return $jawaban->soal_id == $soal->id &&
                                                                    $jawaban->index_jawaban == $index_jawaban &&
                                                                    $jawaban->is_fix;
                                                            });

                                                            // Cek apakah mahasiswa ini sudah pernah menjawab
                                                            $jawaban_mahasiswa = $jawaban_all->first(function (
                                                                $jawaban,
                                                            ) use ($soal, $index_jawaban) {
                                                                return $jawaban->soal_id == $soal->id &&
                                                                    $jawaban->index_jawaban == $index_jawaban &&
                                                                    $jawaban->mahasiswa_id ==
                                                                        Auth::user()->mahasiswa->id;
                                                            });
                                                        @endphp

                                                        {{-- Jika sudah fix, tampilkan info --}}
                                                        @if ($jawaban_fix)
                                                            @if ($soal->type_penyelesaian == 'kelompok')
                                                                <p>Soal kelompok sudah dijawab</p>
                                                            @endif

                                                            {{-- Tampilkan isi jawaban jika ada --}}
                                                            @if ($jawaban_mahasiswa)
                                                                <div
                                                                    class="flex flex-col rounded-md border border-dashed p-2">
                                                                    <p class="border-b text-sm">
                                                                        {{ $soal->type_penyelesaian == 'kelompok' ? 'Jawaban Kelompok Anda' : 'Jawaban Anda' }}
                                                                    </p>
                                                                    @if ($jawaban_mahasiswa->jawaban == '')
                                                                        <div class="text-red-500">Tidak ada jawaban
                                                                        </div>
                                                                    @else
                                                                        <div class="text-sm mt-2">
                                                                            {!! $jawaban_mahasiswa->jawaban !!}</div>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        @else
                                                            {{-- Jika belum fix --}}
                                                            @if ($jawaban_mahasiswa)
                                                                {{-- Jika sudah pernah jawab tapi belum fix --}}
                                                                <div class="w-full cursor-pointer rounded-md bg-yellow-400 px-2 py-1 text-center hover:bg-yellow-500 md:w-24"
                                                                    wire:click='send_id_soal_update({{ $soal->id }}, {{ $index_jawaban }})'>
                                                                    Ganti
                                                                    {{ $index_jawaban > 1 ? $index_jawaban : '' }}
                                                                </div>
                                                            @else
                                                                {{-- Jika belum jawab sama sekali --}}
                                                                <div class="w-full cursor-pointer rounded-md bg-emerald-400 px-2 py-1 text-center text-white hover:bg-emerald-500 md:w-24"
                                                                    wire:click='send_id_soal({{ $soal->id }}, {{ $index_jawaban }})'>
                                                                    Jawab
                                                                    {{ $index_jawaban > 1 ? $index_jawaban : '' }}
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endforeach



                                                </div>
                                            @else
                                                @foreach ($jawaban_fixs[$soal->id] as $key => $jawaban)
                                                    <div class="flex flex-row items-center gap-2">
                                                        @if ($jawaban['is_correct'])
                                                            <div
                                                                class=" flex flex-col p-2 rounded-md border items-center">
                                                                @if ($jawaban['is_true'])
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor"
                                                                        class="size-6 text-green-500">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="m4.5 12.75 6 6 9-13.5" />
                                                                    </svg>
                                                                @else
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor"
                                                                        class="size-6 text-red-500">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M6 18 18 6M6 6l12 12" />
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        <div class="flex flex-col rounded-md border border-dashed p-2">
                                                            <p class="border-b text-sm ">
                                                                {{ $soal->type_penyelesaian == 'kelompok' ? 'Jawaban Kelompok anda' : 'Jawaban anda' }}
                                                            <p>
                                                                @if ($jawaban['jawaban'] == '')
                                                                    <div class="text-red-500">Tidak ada jawaban</div>
                                                                @else
                                                                    <div class="text-sm mt-2">{!! $jawaban['jawaban'] !!}
                                                                    </div>
                                                                @endif
                                                        </div>
                                                    </div>
                                                    @if ($jawaban->is_fix)
                                                        <div class="flex flex-col rounded-md border border-dashed p-2">
                                                            <p class="border-b text-sm "> Kunci Jawaban
                                                            <p>
                                                                @if ($soal['kunci_jawaban'] == '')
                                                                    <div class="text-red-500 text-sm mt-2">Kunci
                                                                        jawaban tidak tersedia</div>
                                                                @else
                                                                    <div class="text-sm mt-2">{!! $soal['kunci_jawaban'] !!}
                                                                    </div>
                                                                @endif
                                                        </div>
                                                        @if ($jawaban->is_correct)
                                                            <div class="flex flex-row items-center gap-2">
                                                                <div
                                                                    class=" flex flex-col p-2 rounded-md border items-center">
                                                                    <p class="border-b text-sm "> Bobot nilai
                                                                    <p>
                                                                    <p class="font-bold text-sm mt-2">
                                                                        {{ $jawaban['bobot_nilai'] }}</p>
                                                                </div>
                                                                <div
                                                                    class="rounded-md border border-yellow-400 border-dashed p-2 ">
                                                                    <p class="border-b text-sm "> Feedback dosen
                                                                    <p>
                                                                    <div class="text-sm font-bold mt-2">
                                                                        {!! $jawaban['feedback_dosen'] ?? 'Tidak ada Feedback Dosen' !!}</div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                        @if ($soal->type_penyelesaian == 'kelompok')
                                            <div class="flex md:justify-end">
                                                <button
                                                    class="flex w-full flex-row items-center gap-2 rounded bg-emerald-500 px-4 py-1 font-bold text-white hover:bg-emerald-700 md:w-64"
                                                    wire:click='chatDiskusi({{ $soal->id }})'>
                                                    <svg class="icon icon-tabler icons-tabler-outline icon-tabler-brand-hipchat"
                                                        fill="none" height="24" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        stroke="currentColor" viewBox="0 0 24 24" width="24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M0 0h24v24H0z" fill="none" stroke="none" />
                                                        <path
                                                            d="M17.802 17.292s.077 -.055 .2 -.149c1.843 -1.425 3 -3.49 3 -5.789c0 -4.286 -4.03 -7.764 -9 -7.764c-4.97 0 -9 3.478 -9 7.764c0 4.288 4.03 7.646 9 7.646c.424 0 1.12 -.028 2.088 -.084c1.262 .82 3.104 1.493 4.716 1.493c.499 0 .734 -.41 .414 -.828c-.486 -.596 -1.156 -1.551 -1.416 -2.29z" />
                                                        <path d="M7.5 13.5c2.5 2.5 6.5 2.5 9 0" />
                                                    </svg>
                                                    <p>Diskusi dengan kelompok</p>
                                                </button>
                                            </div>
                                        @endif
                                    @endforeach
                                </ul>
                            @endforeach
                            <div class="rounded-md bg-white p-2">{{ $main_soals->links(data: ['scrollTo' => false]) }}
                            </div>

                            <div class="flex flex-row justify-between gap-2 rounded-md bg-white md:justify-end md:p-2">
                                <button
                                    class="flex w-full flex-row items-center gap-2 rounded bg-emerald-500 px-4 py-1 font-bold text-white hover:bg-emerald-700 md:w-64"
                                    wire:click='chatDosen("{{ $mahasiswa_id }}")'>
                                    <svg class="icon icon-tabler icons-tabler-outline icon-tabler-brand-hipchat"
                                        fill="none" height="24" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" width="24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0h24v24H0z" fill="none" stroke="none" />
                                        <path
                                            d="M17.802 17.292s.077 -.055 .2 -.149c1.843 -1.425 3 -3.49 3 -5.789c0 -4.286 -4.03 -7.764 -9 -7.764c-4.97 0 -9 3.478 -9 7.764c0 4.288 4.03 7.646 9 7.646c.424 0 1.12 -.028 2.088 -.084c1.262 .82 3.104 1.493 4.716 1.493c.499 0 .734 -.41 .414 -.828c-.486 -.596 -1.156 -1.551 -1.416 -2.29z" />
                                        <path d="M7.5 13.5c2.5 2.5 6.5 2.5 9 0" />
                                    </svg>
                                    <p>Chat dosen</p>
                                </button>
                                @if ($master_fix == false)
                                    <button
                                        class="flex w-full flex-row items-center gap-2 rounded bg-emerald-500 px-4 py-1 font-bold text-white hover:bg-emerald-700 md:w-64"
                                        wire:click='kirim_semua_jawaban'>
                                        <svg class="icon icon-tabler icons-tabler-outline icon-tabler-brand-telegram"
                                            fill="none" height="24" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" stroke="currentColor"
                                            viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 0h24v24H0z" fill="none" stroke="none" />
                                            <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />
                                        </svg>
                                        <p>Kirim Jawaban</p>
                                    </button>
                                @endif
                            </div>


                        </div>

                        @if ($show_timer)
                            <div class="mt-14 hidden w-[30%] justify-center p-2 md:flex"></div>
                            <div class="fixed right-2 top-16 w-32 rounded-md bg-white shadow-md md:w-60 md:p-2">
                                <div class="flex w-full flex-col">
                                    <div class="flex flex-col items-center overflow-hidden rounded-md border">
                                        <div
                                            class="w-full bg-emerald-600 text-center text-sm text-white md:px-2 md:py-1 ">
                                            Timer
                                        </div>
                                        <div class="flex w-full flex-row items-center justify-center bg-white">
                                            <span x-text="jam" class="text-sm font-bold md:p-2 md:text-lg"></span>:
                                            <span x-text="menit" class="text-sm font-bold md:p-2 md:text-lg"></span>:
                                            <span x-text="detik" class="text-sm font-bold md:p-2 md:text-lg"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif
                    </div>
                    <x-modal :show="$errors->isNotEmpty()" focusable maxWidth="2xl" name="jawab_soal">
                        <form class="p-6" wire:submit="{{ $updated ? 'jawabActionUpdated' : 'jawabAction' }}">

                            <h2 class="text-center text-lg font-medium uppercase text-gray-900 dark:text-gray-100">
                                {{ __('Kirim Jawaban') }}
                            </h2>

                            <div wire:ignore>
                                <textarea class="" id="jawab_soal" wire:model=''></textarea>

                            </div>
                            <div class="mt-6 flex justify-end">
                                <x-secondary-button wire:click="closeModal">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-danger-button class="ms-3">
                                    {{ $updated ? 'Update' : 'Submit' }}
                                </x-danger-button>
                            </div>
                        </form>
                    </x-modal>
                    <x-popup :show="$show_timer" focusable name="popup-konfirmasi">
                        <div class="m-4 flex flex-col items-center justify-center gap-4">
                            <p>Apakah anda sudah siap untuk mengerjakan soal?
                            <p>
                            <div class="flex flex-row gap-2">
                                <button class="rounded-md bg-red-600 px-2 py-1 text-white"
                                    wire:click="konfirmasi_tolak">Tidak</button>
                                <button class="rounded-md bg-emerald-600 px-5 py-1 text-white"
                                    @click="start_timer">Ya</button>
                            </div>

                        </div>
                    </x-popup>

                </div>

                @push('scripts')
                    <script>
                        var editor_config = {
                            path_absolute: "/",
                            selector: '#jawab_soal',
                            relative_urls: false,
                            plugins: [
                                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                                "searchreplace wordcount visualblocks visualchars code fullscreen",
                                "insertdatetime media nonbreaking save table directionality",
                                "emoticons template paste textpattern"
                            ],
                            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | rumus",
                            setup: (editor) => {
                                editor.on('init change', function() {
                                    editor.save();
                                });
                                editor.on('change', function(e) {
                                    let id = @this.id_soal
                                    let index = @this.index_jawaban
                                    @this.set(`jawabans.${id}.${index}`, editor.getContent());
                                });

                                editor.ui.registry.addMenuButton('rumus', {
                                    text: 'Rumus',
                                    icon: 'math',
                                    fetch: (callback) => {
                                        const items = [{
                                                type: 'menuitem',
                                                text: 'Penjumlahan',
                                                onAction: () => {
                                                    editor.insertContent('\\( a + b \\)');
                                                }
                                            },
                                            {
                                                type: 'menuitem',
                                                text: 'Pengurangan',
                                                onAction: () => {
                                                    editor.insertContent('\\( a - b \\)');
                                                }
                                            },
                                            {
                                                type: 'menuitem',
                                                text: 'Perkalian',
                                                onAction: () => {
                                                    editor.insertContent('\\( a \\times b \\)');
                                                }
                                            },
                                            {
                                                type: 'menuitem',
                                                text: 'Pembagian',
                                                onAction: () => {
                                                    editor.insertContent('\\( \\frac{a}{b} \\)');
                                                }
                                            },
                                            {
                                                type: 'menuitem',
                                                text: 'Persamaan Kuadrat',
                                                onAction: () => {
                                                    editor.insertContent(
                                                        '\\( x = \\frac{-b \\pm \\sqrt{b^2 - 4ac}}{2a} \\)');
                                                }
                                            },
                                            {
                                                type: 'menuitem',
                                                text: 'Integral x²',
                                                onAction: () => {
                                                    editor.insertContent(
                                                        '\\( \\int x^2 \\, dx = \\frac{1}{3}x^3 + C \\)');
                                                }
                                            },
                                            {
                                                type: 'menuitem',
                                                text: 'Limit sin(x)/x',
                                                onAction: () => {
                                                    editor.insertContent(
                                                        '\\( \\lim_{x \\to 0} \\frac{\\sin x}{x} = 1 \\)');
                                                }
                                            },
                                            {
                                                type: 'menuitem',
                                                text: 'Turunan f(x) = xⁿ',
                                                onAction: () => {
                                                    editor.insertContent('\\( \\frac{d}{dx}x^n = nx^{n-1} \\)');
                                                }
                                            },
                                            {
                                                type: 'menuitem',
                                                text: 'Teorema Pythagoras',
                                                onAction: () => {
                                                    editor.insertContent('\\( a^2 + b^2 = c^2 \\)');
                                                }
                                            }
                                        ];
                                        callback(items);
                                    }
                                });

                                // Fungsi render ulang MathJax di iframe editor
                                function renderMathInEditor() {
                                    const iframe = document.querySelector('iframe.tox-edit-area__iframe');
                                    const iframeDoc = iframe?.contentDocument;
                                    if (iframeDoc && iframe.contentWindow.MathJax) {
                                        iframe.contentWindow.MathJax.typesetPromise([iframeDoc.body]);
                                    }
                                }
                            },

                            file_picker_callback: function(callback, value, meta) {
                                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                                    'body')[0].clientWidth;
                                var y = window.innerHeight || document.documentElement.clientHeight || document
                                    .getElementsByTagName('body')[0].clientHeight;

                                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
                                if (meta.filetype == 'image') {
                                    cmsURL = cmsURL + "&type=Images";
                                } else {
                                    cmsURL = cmsURL + "&type=Files";
                                }

                                tinyMCE.activeEditor.windowManager.openUrl({
                                    url: cmsURL,
                                    title: 'Filemanager',
                                    width: x * 0.8,
                                    height: y * 0.8,
                                    resizable: "yes",
                                    close_previous: "no",
                                    onMessage: (api, message) => {
                                        callback(message.content);
                                    }
                                });
                            }
                        };

                        tinymce.init(editor_config);
                        window.addEventListener('hapus-textarea', event => {
                            tinymce.get("jawab_soal").setContent("");
                        })
                        window.addEventListener('set-textarea', event => {
                            tinymce.get("jawab_soal").setContent(event.detail.jawaban);

                        })
                    </script>
                    <script>
                        window.MathJax = {
                            tex: {
                                inlineMath: [
                                    ['\\(', '\\)']
                                ]
                            },
                            svg: {
                                fontCache: 'global'
                            }
                        };
                    </script>
                    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js" defer></script>

                    <script>
                        // function startTimer(jam, menit, detik) {

                        //     var total = jam * 3600 + menit * 60 + detik

                        //     setInterval(() => {

                        //         total--

                        //         if (total > 0) {

                        //             var showJam = document.getElementById("jam");
                        //             var showMenit = document.getElementById("menit");
                        //             var showDetik = document.getElementById("detik");

                        //             var jam = Math.floor(total / 3600)
                        //             var menit = Math.floor((total / 60) - (jam * 60))
                        //             var detik = total - ((jam * 3600) + (menit * 60))

                        //             var jamFix = jam < 10 ? `0${jam}` : jam
                        //             var menitFix = menit < 10 ? `0${menit}` : menit
                        //             var detikFix = detik < 10 ? `0${detik}` : detik

                        //             // @this.set('jam', jam);
                        //             this.jamLoad = jam
                        //             this.menitLoad = menit
                        //             this.menitLoad = detik
                        //             // @this.set('menit', menit);
                        //             // @this.set('detik', detik);

                        //             Livewire.dispatch('waktu_aktif', 'popup-konfirmasi')

                        //             showJam.innerHTML = jamFix
                        //             showMenit.innerHTML = menitFix
                        //             showDetik.innerHTML = detikFix

                        //         } else {
                        //             Livewire.dispatch('waktu_selesai', )
                        //         }

                        //     }, 1000)

                        // }
                    </script>
                @endpush

            </div>
        </div>
    </div>
</div>
