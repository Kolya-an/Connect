<div class="spec_register1_left_block">
    <label class="_flex-display _align-center more_filter_checkbox">
        <input
            wire:model.live.debounce.500ms="at_home"
            id="at_home"
            type="checkbox"
            name="at_home"
            class="form-check-input"
            {{ $at_home ? 'checked' : '' }}
        >
        <span class="checkmark"></span>
        <span class="check_title">{{__('Виїзд додому')}}</a></span>
    </label>
</div>
