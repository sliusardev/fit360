<x-filament::page>
    <x-filament::section>
        <div class="text-center py-4">
            <h2 class="text-xl font-bold mb-4">QR-код для анкети "{{ $record->title }}"</h2>

            <div class="bg-white p-4 rounded-lg inline-block mb-4" id="qrCodeContainer">
                {!! $qrCode !!}
            </div>

            <p class="mb-4">Розмістіть цей QR-код на рецепції для легкого доступу клієнтів до анкети.</p>

            <div class="mt-4 space-x-2">
                <x-filament::button
                    tag="a"
                    href="{{ $surveyUrl }}"
                    target="_blank"
                >
                    Відкрити анкету
                </x-filament::button>

                <x-filament::button
                    id="copyQrCodeBtn"
                >
                    Копіювати QR-код
                </x-filament::button>

            </div>

            <div id="copyStatus" class="mt-2 text-sm hidden text-primary-600"></div>
        </div>
    </x-filament::section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const copyBtn = document.getElementById('copyQrCodeBtn');
            const qrContainer = document.getElementById('qrCodeContainer');
            const copyStatus = document.getElementById('copyStatus');

            copyBtn.addEventListener('click', function() {
                const qrSvg = qrContainer.querySelector('svg');

                if (qrSvg) {
                    const svgData = new XMLSerializer().serializeToString(qrSvg);
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

                    // Create an image to draw on canvas
                    const img = new Image();
                    img.onload = function() {
                        canvas.width = img.width;
                        canvas.height = img.height;
                        ctx.drawImage(img, 0, 0);

                        // Convert to blob and copy to clipboard
                        canvas.toBlob(function(blob) {
                            navigator.clipboard.write([
                                new ClipboardItem({'image/png': blob})
                            ]).then(function() {
                                copyStatus.textContent = 'QR-код скопійовано в буфер обміну!';
                                copyStatus.classList.remove('hidden');

                                setTimeout(() => {
                                    copyStatus.classList.add('hidden');
                                }, 2000);
                            }).catch(function() {
                                copyStatus.textContent = 'Не вдалося скопіювати QR-код';
                                copyStatus.classList.remove('hidden');
                            });
                        });
                    };

                    img.src = 'data:image/svg+xml;base64,' + btoa(svgData);
                }
            });
        });
    </script>
</x-filament::page>
