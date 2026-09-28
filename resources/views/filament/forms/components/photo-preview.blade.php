@php
    $record = $getRecord();
    $doctorPhoto = $record?->doctorPhoto;

    // Автоматичний пошук шляху до фото "ДО" та "ПІСЛЯ"
    $rawBefore = $doctorPhoto?->photo_before 
        ?? $doctorPhoto?->before_path 
        ?? $doctorPhoto?->before 
        ?? $doctorPhoto?->before_image;

    $rawAfter = $doctorPhoto?->photo_after 
        ?? $doctorPhoto?->after_path 
        ?? $doctorPhoto?->after 
        ?? $doctorPhoto?->after_image;

    // Хелпер для формування коректного URL (підтримує як uploads/doctor/..., так і storage/... або повні URL)
    $helperGetUrl = function ($path) {
        if (!$path) return null;
        if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
        
        $cleanPath = ltrim($path, '/');
        if (str_starts_with($cleanPath, 'uploads/')) {
            return asset($cleanPath);
        }
        if (str_starts_with($cleanPath, 'doctor/')) {
            return asset('uploads/' . $cleanPath);
        }
        return \Illuminate\Support\Facades\Storage::disk('public')->url($cleanPath);
    };

    $urlBefore = $helperGetUrl($rawBefore);
    $urlAfter = $helperGetUrl($rawAfter);
@endphp

<div class="rounded-xl border border-gray-200 bg-gray-50 p-6 dark:border-gray-800 dark:bg-gray-900/50">
    <div class="flex flex-col gap-4">
        @if($urlBefore || $urlAfter)
            <div class="photo_list_block">
                <div class="photo_item">
                    <div style="display: flex; flex-direction: row; width: 100%; height: 320px; overflow: hidden;">
                        
                        <!-- Фото ДО (Left) -->
                        <div>
                            @if($urlBefore)
                                <a href="{{ $urlBefore }}" target="_blank">
                                    <img  src="{{ $urlBefore }}" alt="Фото ДО" class="w-full object-cover" style="border-radius: 20px 0 0 20px; height: 320px; display: block;">
                                </a>
                            @else
                                <div class="flex items-center justify-center bg-gray-100 dark:bg-gray-800" style="height: 320px;">
                                    <span class="text-xs text-gray-400">Фото ДО відсутнє</span>
                                </div>
                            @endif
                        </div>

                        <!-- Фото ПІСЛЯ (Right) -->
                        <div>
                            @if($urlAfter)
                                <a href="{{ $urlAfter }}" target="_blank">
                                    <img src="{{ $urlAfter }}" alt="Фото ПІСЛЯ" class="w-full object-cover" style="border-radius: 0 20px 20px 0; height: 320px; display: block;">
                                </a>
                             @else
                                <div class="flex items-center justify-center bg-gray-100 dark:bg-gray-800" style="height: 320px;">
                                    <span class="text-xs text-gray-400">Фото ПІСЛЯ відсутнє</span>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        @else
            <div class="flex h-48 items-center justify-center rounded-lg border border-dashed border-gray-300 bg-white dark:border-gray-700 dark:bg-gray-900">
                <div class="text-center text-gray-400">
                    <svg class="mx-auto h-10 w-10 text-gray-350" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="mt-2 block text-xs">Не вдалося завантажити фото (doctor_photo_id: {{ $record?->doctor_photo_id ?? 'null' }})</span>
                </div>
            </div>
        @endif
    </div>
</div>