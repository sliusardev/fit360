<x-filament::page>
    <x-filament::section>
        <div class="text-center py-4">
            <h2 class="text-xl font-bold mb-4">QR-код для анкети "{{ $record->title }}"</h2>

            <div class="bg-white p-4 rounded-lg inline-block mb-4">
                {!! $qrCode !!}
            </div>

            <p class="mb-4">Розмістіть цей QR-код на рецепції для легкого доступу клієнтів до анкети.</p>

            <div class="mt-4">
                <x-filament::button
                    tag="a"
                    href="{{ $surveyUrl }}"
                    target="_blank"
                >
                    Відкрити анкету
                </x-filament::button>
            </div>
        </div>
    </x-filament::section>
</x-filament::page>
