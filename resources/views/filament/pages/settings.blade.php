<x-filament-panels::page>

    <div>
        <form wire:submit="submit">
            {{ $this->form }}

            <x-filament::button type="submit" class="mt-3">
                Submit
            </x-filament::button>

        </form>

        <x-filament-actions::modals />
    </div>

</x-filament-panels::page>
