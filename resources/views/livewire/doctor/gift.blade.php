<div class="spec_register1_left_block">
    <label class="_flex-display _align-center more_filter_checkbox">
        <input
            wire:model.live.debounce.500ms="gift"
            id="gift"
            type="checkbox"
            name="gift"
            class="form-check-input"
            {{ $gift ? 'checked' : '' }}
        >
        <span class="checkmark"></span>
        <span class="check_title">{{__('Подарунок за перший візит')}}</a></span>
    </label>
</div>
