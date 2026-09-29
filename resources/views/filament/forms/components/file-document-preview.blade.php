@php
    use Illuminate\Support\Facades\Storage;

    $path = $record?->file_document;
@endphp

@if ($path)
    @php
        $url = Storage::disk('public_uploads')->url($path);
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    @endphp

    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif']))
        <div class="flex flex-col gap-3">
            <div>
                <img
                    src="{{ $url }}"
                    alt="Документ згоди"
                    class="max-w-full rounded-lg border border-gray-200 shadow-sm"
                    style="max-height: 500px; object-fit: contain;"
                >
            </div>

            <div>
                <a
                    href="{{ $url }}"
                    target="_blank"
                    class="fi-btn fi-btn-size-md inline-flex items-center gap-2"
                >
                    <x-heroicon-o-arrow-top-right-on-square class="w-5 h-5" />
                    Відкрити оригінал
                </a>
            </div>
        </div>

    @elseif ($extension === 'pdf')
        <div class="flex flex-col gap-3">
            <iframe
                src="{{ $url }}"
                style="width: 100%; height: 600px; border: 1px solid #e5e7eb; border-radius: 8px;"
            ></iframe>

            <div>
                <a
                    href="{{ $url }}"
                    target="_blank"
                    class="fi-btn fi-btn-size-md inline-flex items-center gap-2"
                >
                    <x-heroicon-o-arrow-top-right-on-square class="w-5 h-5" />
                    Відкрити PDF
                </a>
            </div>
        </div>

    @else
        <a
            href="{{ $url }}"
            target="_blank"
            class="fi-btn fi-btn-size-md inline-flex items-center gap-2"
        >
            <x-heroicon-o-document-arrow-down class="w-5 h-5" />
            Відкрити файл
        </a>
    @endif
@else
    <div class="text-gray-500">
        Документ не завантажено
    </div>
@endif