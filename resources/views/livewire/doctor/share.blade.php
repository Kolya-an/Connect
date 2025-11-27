<div class="spec_register1_right_block">
    <h5>{{__('Посилання на соціальну мережу')}}</h5>
    <div class="search_field search_field_input">
        <input
            id="add_share"
            class="add_share"
            type="text"
            placeholder="{{__('https://...')}}"
            wire:model.defer="share"
            wire:keydown.enter="save"
            wire:blur="save"
        />
    </div>
</div>
