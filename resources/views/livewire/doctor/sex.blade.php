<div class="spec_register1_left_block">
    <div class="doctor_name">
        <input
            id="add_name"
            class="client_add_name"
            type="text"
            wire:model.live="name"
            placeholder="Ваше ім'я"
        />
        <input
            id="add_second_name"
            class="client_add_second_name"
            type="text"
            wire:model.live="second_name"
            placeholder="{{__('Ваше прізвище')}}"
        />
    </div>
    <h5>{{__('Ваша стать')}}</h5>
    <label class="custom-radio">
        <input type="radio" wire:model="sex" wire:change="updateSex('female')" value="female">
        <span></span> {{__('Жінка')}}
    </label>
    <label class="custom-radio">
        <input type="radio" wire:model="sex" wire:change="updateSex('male')" value="male">
        <span></span> {{__('Чоловік')}}
    </label>
</div>
