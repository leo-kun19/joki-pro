<div>
    <div class="flex h-screen flex-col p-4">
        @if (auth()->user()->mahasiswa)
            <a aria-current="page"
                class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                href="{{ route('pembelajaran.master_soal', [$pembelajaran->code, $this->master_soal_id]) }}">
                <svg class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left" fill="none" height="24"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor"
                    viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0h24v24H0z" fill="none" stroke="none" />
                    <path d="M15 6l-6 6l6 6" />
                </svg>
                <span class="ms-3 flex-1 whitespace-nowrap">Kembali ke Master Soal</span>
            </a>
        @endif
        <div class="mb-52 mt-2 flex flex-col gap-2 overflow-y-scroll" wire:poll.visible>
            <div class="flex items-start gap-2.5">
                <div class="leading-1.5 flex w-full flex-col rounded-md border-gray-200 bg-white dark:bg-gray-700">
                    <div class="p-2 text-sm font-normal text-gray-900 dark:text-white">
                        {!! $soal->pertanyaan !!}
                    </div>
                </div>
            </div>
            @if ($diskusi_kelompok->chat_diskusi_kelompoks)
                @foreach ($diskusi_kelompok->chat_diskusi_kelompoks as $value)
                    @if ($value->pengirim_id == auth()->user()->id)
                        <div class="flex justify-end gap-2.5 " >
                            <div
                                class="leading-1.5 flex flex-col rounded-e-xl rounded-es-xl border-gray-200 bg-emerald-400 p-4 dark:bg-gray-700">
                                @if ($value->parent)
                                    <div class="rounded-md border-l-2 border-emerald-200 bg-gray-200 p-2">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $value->parent->pengirim->mahasiswa ? $value->parent->pengirim->mahasiswa->nama : $value->parent->pengirim->dosen->nama }}
                                        </span>
                                        <div class="p-2">
                                            {!! $value->parent->isi_pesan !!}
                                        </div>
                                    </div>
                                @endif
                                <div class="flex items-center space-x-2 ">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">Anda |
                                        {{ auth()->user()->mahasiswa ? auth()->user()->mahasiswa->nama : auth()->user()->dosen->nama }}</span>
                                    <span
                                        class="text-sm font-normal text-gray-200 dark:text-gray-400">{{ $value->created_at }}</span>
                                </div>
                                <div class="prose py-2.5 text-sm font-normal text-white">
                                    {!! $value->isi_pesan !!}
                                </div>

                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-2.5">

                            <div
                                class="leading-1.5 flex flex-col rounded-e-xl rounded-es-xl border-gray-200 bg-white p-2 dark:bg-gray-700">

                                @if ($value->parent)
                                    <div class="rounded-md border-l-2 border-emerald-700 bg-gray-200 p-2">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $value->parent->pengirim->mahasiswa ? $value->parent->pengirim->mahasiswa->nama : $value->parent->pengirim->dosen->nama }}
                                        </span>
                                        <div class="p-2">
                                            {!! $value->parent->isi_pesan !!}
                                        </div>
                                    </div>
                                @endif

                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <span
                                        class="text-sm font-semibold text-gray-900 dark:text-white">{{ $value->pengirim->mahasiswa ? $value->pengirim->mahasiswa->nama : $value->pengirim->dosen->nama }}</span>
                                    <span
                                        class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $value->created_at }}</span>
                                </div>
                                <div class="py-2.5 text-sm font-normal text-gray-900 dark:text-white">
                                    {!! $value->isi_pesan !!}</div>
                                <span
                                    class="cursor-pointer text-sm font-normal text-emerald-500 hover:text-emerald-600 dark:text-gray-400"
                                    wire:click='balasChat({{ $value->id }})'>Balas</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <p class="text-center text-gray-500 dark:text-gray-400">Belum ada Dikusi</p>
            @endif
        </div>
        <div class="">
            <div class="fixed bottom-0 right-0 flex w-full flex-col gap-2 p-2">
                @if ($chat_dibalas)
                    <div class="relative mx-2 rounded-md bg-white p-2">
                        <div class="rounded-md border-l-2 border-emerald-700 bg-gray-200 p-2">
                            <span class="absolute -right-2 -top-3 cursor-pointer font-bold"
                                wire:click='hapusChatDibalas'>X</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $chat_dibalas->pengirim->mahasiswa ? $chat_dibalas->pengirim->mahasiswa->nama : $chat_dibalas->pengirim->dosen->nama }}
                            </span>
                            <div>
                                {!! $chat_dibalas->isi_pesan !!}
                            </div>
                        </div>
                    </div>
                @endif

                <div class="w-full" wire:ignore>
                    <textarea id="isi_pesan"></textarea>
                </div>
                <div>
                    @if ($isi_pesan)
                        <button class='rounded bg-emerald-600 px-4 py-2 font-bold text-white hover:bg-emerald-700'
                            wire:click="send_chat">Kirim</button>
                    @else
                        <button
                            class='cursor-not-allowed rounded bg-gray-500 px-4 py-2 font-bold text-white hover:bg-gray-600'>Kirim</button>
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        var editor_config = {
            path_absolute: "/",
            selector: '#isi_pesan',
            relative_urls: false,
            height: 150,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table directionality",
                "emoticons template paste textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            setup: (editor) => {
                editor.on('init change', function() {
                    editor.save();
                });
                editor.on('change', function(e) {
                    @this.set(`isi_pesan`, editor.getContent());
                });
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
            tinymce.get("isi_pesan").setContent("");
        })
        window.addEventListener('set-textarea', event => {
            tinymce.get("jawab_soal").setContent(event.detail.jawaban);

        })
    </script>
@endpush
