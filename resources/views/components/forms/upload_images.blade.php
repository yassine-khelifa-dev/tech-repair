@props(['name'])

@php
    $inputId = $name . '-' . uniqid();
@endphp

{{-- Images --}}
<div class="text-white mb-5" data-image-upload>
    <div class="mb-3 flex items-center justify-between gap-3">
        <div>
            <h1 class="text-white font-semibold">Upload Photos</h1>
            <p class="text-xs text-gray-400">Select repair photos before saving this form.</p>
        </div>

        <p class="hidden text-xs font-medium text-blue-300" data-upload-count></p>
    </div>

    <div class="grid gap-4 lg:grid-cols-[minmax(220px,280px)_1fr]">

        <label for="{{ $inputId }}"
            class="flex h-40 w-full cursor-pointer flex-col items-center justify-center rounded-xl border border-dashed border-gray-600 bg-gray-900/70 px-4 text-center transition hover:border-blue-400 hover:bg-gray-800">
            <div class="flex flex-col items-center justify-center text-body pt-5 pb-6">
                <svg class="w-8 h-8 mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2" />
                </svg>
                <p class="mb-2 text-sm"><span class="font-semibold">Click to upload</span></p>
                <p class="text-xs text-gray-400">PNG, JPG, GIF or WEBP up to 5 MB</p>
            </div>
            <input id="{{ $inputId }}" name="{{ $name }}[]" type="file" class="hidden" accept="image/*"
                multiple />
        </label>

        <div>
            <div class="hidden grid-cols-2 gap-3 sm:grid-cols-3 xl:grid-cols-4" data-preview-grid></div>

            <div class="flex min-h-40 items-center justify-center rounded-xl border border-gray-700 bg-gray-900/40 px-4 text-center text-sm text-gray-500"
                data-empty-state>
                No photos selected yet.
            </div>
        </div>
    </div>

    <x-forms.error-message name="{{ $name }}" />
</div>

@once
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-image-upload]').forEach((uploadRoot) => {
                const input = uploadRoot.querySelector('input[type="file"]');
                const grid = uploadRoot.querySelector('[data-preview-grid]');
                const emptyState = uploadRoot.querySelector('[data-empty-state]');
                const countLabel = uploadRoot.querySelector('[data-upload-count]');

                if (!input || !grid || !emptyState || !countLabel) {
                    return;
                }

                let selectedFiles = [];

                const formatSize = (bytes) => {
                    if (bytes < 1024 * 1024) {
                        return `${Math.max(1, Math.round(bytes / 1024))} KB`;
                    }

                    return `${(bytes / 1024 / 1024).toFixed(1)} MB`;
                };

                const escapeHtml = (value) => value.replace(/[&<>"']/g, (character) => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;',
                }[character]));

                const syncInputFiles = () => {
                    const dataTransfer = new DataTransfer();
                    selectedFiles.forEach((file) => dataTransfer.items.add(file));
                    input.files = dataTransfer.files;
                };

                const renderPreviews = () => {
                    grid.innerHTML = '';
                    grid.classList.toggle('hidden', selectedFiles.length === 0);
                    grid.classList.toggle('grid', selectedFiles.length > 0);
                    emptyState.classList.toggle('hidden', selectedFiles.length > 0);
                    countLabel.classList.toggle('hidden', selectedFiles.length === 0);
                    countLabel.textContent = selectedFiles.length === 1
                        ? '1 photo selected'
                        : `${selectedFiles.length} photos selected`;

                    selectedFiles.forEach((file, index) => {
                        const previewUrl = URL.createObjectURL(file);
                        const fileName = escapeHtml(file.name);
                        const card = document.createElement('div');
                        card.className = 'group relative overflow-hidden rounded-xl border border-gray-700 bg-gray-900 shadow-sm';

                        card.innerHTML = `
                            <button type="button"
                                class="absolute right-2 top-2 z-10 inline-flex h-7 w-7 items-center justify-center rounded-full bg-gray-950/85 text-sm font-bold text-white shadow transition hover:bg-red-600"
                                aria-label="Remove selected photo"
                                data-remove-index="${index}">
                                &times;
                            </button>
                            <img src="${previewUrl}" alt="${fileName}"
                                class="h-28 w-full object-cover">
                            <div class="space-y-0.5 px-3 py-2">
                                <p class="truncate text-xs font-medium text-gray-100" title="${fileName}">${fileName}</p>
                                <p class="text-[11px] text-gray-400">${formatSize(file.size)}</p>
                            </div>
                        `;

                        card.querySelector('img').addEventListener('load', () => {
                            URL.revokeObjectURL(previewUrl);
                        });

                        grid.appendChild(card);
                    });
                };

                input.addEventListener('change', () => {
                    selectedFiles = Array.from(input.files || []);
                    renderPreviews();
                });

                grid.addEventListener('click', (event) => {
                    const removeButton = event.target.closest('[data-remove-index]');

                    if (!removeButton) {
                        return;
                    }

                    selectedFiles.splice(Number(removeButton.dataset.removeIndex), 1);
                    syncInputFiles();
                    renderPreviews();
                });
            });
        });
    </script>
@endonce
