<div x-data="{ show: @entangle('show') }" x-show="show" x-transition:enter="transition ease-in-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in-out duration-300" x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90" @toast-shown.window="setTimeout(() => show = false, 3000)"
    class="fixed top-24 right-4 z-50">
    <div class="bg-white border-l-4 p-4 shadow-md"
        :class="{
            'border-green-500': '{{ $type }}'
            === 'success',
            'border-blue-500': '{{ $type }}'
            === 'info',
            'border-yellow-500': '{{ $type }}'
            === 'warning',
            'border-red-500': '{{ $type }}'
            === 'error'
        }">
        <div class="flex items-center">
            <div class="py-1">
                <svg class="w-6 h-6 mr-4"
                    :class="{
                        'text-green-500': '{{ $type }}'
                        === 'success',
                        'text-blue-500': '{{ $type }}'
                        === 'info',
                        'text-yellow-500': '{{ $type }}'
                        === 'warning',
                        'text-red-500': '{{ $type }}'
                        === 'error'
                    }"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="font-bold">{{ $message }}</p>
            </div>
        </div>
    </div>
</div>
