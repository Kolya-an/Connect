<div class="spec_register1_right_block">
    <h5>Опис</h5>
    <textarea
        id="add_desc"
        class="add_desc"
        placeholder="{{__('Розкажіть про себе')}}"
            wire:model.defer="desc"
            wire:keydown.enter="save"
            wire:blur="save">
    </textarea>
</div>
