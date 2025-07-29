{{-- resources/views/components/confirmation-modal.blade.php --}}
@props(['id', 'formAction', 'method' => 'POST', 'confirmText' => 'OK', 'cancelText' => 'Batal'])

<div id="{{ $id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="{{ $id }}Title"></h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500" id="{{ $id }}Message"></p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="{{ $id }}Confirm" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    {{ $confirmText }}
                </button>
                <button id="{{ $id }}Cancel" class="mt-3 px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    {{ $cancelText }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('{{ $id }}');
        const modalTitle = document.getElementById('{{ $id }}Title');
        const modalMessage = document.getElementById('{{ $id }}Message');
        const confirmButton = document.getElementById('{{ $id }}Confirm');
        const cancelButton = document.getElementById('{{ $id }}Cancel');

        let currentFormToSubmit = null;

        // Fungsi untuk menampilkan modal (dibuat global agar bisa diakses dari onclick)
        window.showConfirmationModal = function(modalId, title, message, formElement) {
            if (modalId === '{{ $id }}') { // Pastikan ini adalah modal yang benar
                modalTitle.textContent = title;
                modalMessage.textContent = message;
                modal.classList.remove('hidden');
                currentFormToSubmit = formElement;
            }
        };

        confirmButton.addEventListener('click', function() {
            modal.classList.add('hidden');
            if (currentFormToSubmit) {
                currentFormToSubmit.submit();
            }
        });

        cancelButton.addEventListener('click', function() {
            modal.classList.add('hidden');
            currentFormToSubmit = null;
        });
    });
</script>
