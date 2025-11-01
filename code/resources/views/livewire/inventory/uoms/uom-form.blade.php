<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">
                {{ $uom ? 'Edit UOM' : 'Create UOM' }}
            </h2>
            <a href="{{ route('uoms.index') }}" 
               wire:navigate
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                Back to UOMs
            </a>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="save" name="uomForm" autocomplete="off" class="space-y-6">
            <!-- Basic Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">UOM Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Code -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                            Code <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               wire:model.live="code" 
                               id="code"
                               name="code"
                               autocomplete="off"
                               maxlength="16"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="e.g., pz, caja, pack"
                               aria-describedby="code-help">
                        @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        <p id="code-help" class="text-xs text-gray-500 mt-1">Maximum 16 characters. Use letters, numbers, dashes, and underscores only.</p>
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               wire:model.live="name" 
                               id="name"
                               name="name"
                               autocomplete="off"
                               maxlength="64"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="e.g., Pieza, Caja, Pack"
                               aria-describedby="name-help">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        <p id="name-help" class="text-xs text-gray-500 mt-1">Maximum 64 characters.</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('uoms.index') }}" 
                   wire:navigate
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                    Cancel
                </a>
                <button type="submit" 
                        name="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                    {{ $uom ? 'Update UOM' : 'Create UOM' }}
                </button>
            </div>
        </form>
    </div>
</div>