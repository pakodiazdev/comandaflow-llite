<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Test UOM Form</h2>
    
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit="save">
        <div class="mb-4">
            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Code</label>
            <input 
                type="text" 
                id="code" 
                wire:model="code"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
        </div>

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
            <input 
                type="text" 
                id="name" 
                wire:model="name"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('uoms.index') }}" 
               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                Save Test
            </button>
        </div>
    </form>
</div>