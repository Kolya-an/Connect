
    <div class="_flex-display _justify-content-center _align-center screen">
        <div class="window add_info_window">

            <div class="_flex-display _justify-content-between _align-center window_top">
                <h4>Залишити відгук</h4>
                <div wire:click="close" class="window_close">X</div>
            </div>

            <div class="search_field search_field_input">
            <textarea
                wire:model="text"
                class="w-full border rounded p-2"
                rows="4"
                placeholder="Ваш відгук..."
            ></textarea>
            @error('text') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror


            <!-- Medical рейтинг -->
            <div class="mt-4">
                <div class="font-semibold mb-1">Оцінка медичної частини:</div>
                <div class="flex space-x-1">
                    @for($i = 1; $i <= 5; $i++)
                        <svg wire:click="$set('medical', {{ $i }})"
                             class="w-8 h-8 cursor-pointer {{ $i <= $medical ? 'text-yellow-400' : 'text-gray-300' }}"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.448a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118L10 13.347l-3.368 2.448c-.784.57-1.838-.197-1.539-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.648 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.955z"/>
                        </svg>
                    @endfor
                </div>
            </div>

            @error('medical') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror

            <!-- Services рейтинг -->
            <div class="mt-4">
                <div class="font-semibold mb-1">Оцінка сервісу:</div>
                <div class="flex space-x-1">
                    @for($i = 1; $i <= 5; $i++)
                        <svg wire:click="$set('service', {{ $i }})"
                             class="w-8 h-8 cursor-pointer {{ $i <= $service ? 'text-yellow-400' : 'text-gray-300' }}"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.448a1 1 0 00-.364 1.118л1.287 3.955c.3.921-.755 1.688-1.54 1.118L10 13.347l-3.368 2.448c-.784.57-1.838-.197-1.539-1.118л1.287-3.955а1 1 0 00-.364-1.118L2.648 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69л1.286-3.955z"/>
                        </svg>
                    @endfor
                </div>
            </div>

            @error('service') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror

            <!-- КНОПКИ -->
            <div class="mt-6 flex justify-end space-x-3">
                <button wire:click="close" class="px-4 py-2 bg-gray-300 rounded">
                    Скасувати
                </button>

                <button wire:click="submit" class="px-4 py-2 bg-green-600 text-white rounded">
                    Відправити
                </button>
            </div>

        </div>
    </div>
