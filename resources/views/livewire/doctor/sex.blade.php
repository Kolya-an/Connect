<div class="spec_register1_left_block">
    <h5>{{__('Ваша стать')}}</h5>
    <label class="custom-radio">
        <input type="radio" wire:model="sex" wire:change="updateSex('female')" value="female">
        <span></span> {{__('Жінка')}}
    </label>
    <label class="custom-radio">
        <input type="radio" wire:model="sex" wire:change="updateSex('male')" value="male">
        <span></span> {{__('Чоловік')}}
    </label>
    <label class="custom-radio">
        <input type="radio" wire:model="sex" wire:change="updateSex('nonbinary')" value="nonbinary">
        <span></span> {{__('Небінарна особістість')}}
    </label>
</div>
