<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Suppliers</h2>
            @can('suppliers.create')
                <a href="{{ route('suppliers.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Supplier
                </a>
            @endcan
        </div>

        <!-- Filters -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Search suppliers..."
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="status" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="suspended">Suspended</option>
                </select>
            </div>

            <!-- Results Count -->
            <div class="flex items-end">
                <span class="text-sm text-gray-600">
                    {{ $suppliers->total() }} suppliers found
                </span>
            </div>
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

        <!-- Suppliers Table -->
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer min-w-[200px]"
                            wire:click="sortBy('name')">
                            <div class="flex items-center">
                                Name
                                @if($sortField === 'name')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/>
                                        </svg>
                                    @endif
                                @endif
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px]">
                            Contact
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer min-w-[100px]"
                            wire:click="sortBy('status')">
                            <div class="flex items-center">
                                Status
                                @if($sortField === 'status')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/>
                                        </svg>
                                    @endif
                                @endif
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[100px]">
                            Products
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[280px] bg-gray-50">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($suppliers as $supplier)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 whitespace-nowrap min-w-[200px]">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $supplier->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $supplier->email }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap min-w-[150px]">
                                <div class="text-sm text-gray-900">{{ $supplier->contact_person }}</div>
                                <div class="text-sm text-gray-500">{{ $supplier->phone }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap min-w-[100px]">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $supplier->status_badge_class }}">
                                    {{ ucfirst($supplier->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 min-w-[100px]">
                                {{ $supplier->products()->count() }} products
                            </td>
                            <td class="px-4 py-4 text-sm font-medium min-w-[280px] bg-white" style="display: table-cell !important; visibility: visible !important;">
                                <div class="flex items-center space-x-2" style="display: flex !important; visibility: visible !important;">
                                    <!-- Debug info -->
                                    
                                    @can('suppliers.read')
                                        <a href="{{ route('suppliers.show', $supplier) }}" 
                                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs"
                                           style="background-color: #3b82f6 !important; color: white !important; padding: 4px 8px !important; border-radius: 4px !important; text-decoration: none !important; display: inline-block !important; visibility: visible !important;"
                                           title="View Details">
                                            👁️ View
                                        </a>
                                    @endcan
                                    
                                    @can('suppliers.update')
                                        <a href="{{ route('suppliers.edit', $supplier) }}" 
                                           class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-xs"
                                           style="background-color: #10b981 !important; color: white !important; padding: 4px 8px !important; border-radius: 4px !important; text-decoration: none !important; display: inline-block !important; visibility: visible !important;"
                                           title="Edit Supplier">
                                            ✏️ Edit
                                        </a>
                                        
                                        <button wire:click="toggleStatus({{ $supplier->id }})" 
                                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs"
                                                style="background-color: #f59e0b !important; color: white !important; padding: 4px 8px !important; border-radius: 4px !important; border: none !important; cursor: pointer !important; display: inline-block !important; visibility: visible !important;"
                                                title="{{ $supplier->status === 'active' ? 'Deactivate' : 'Activate' }} Supplier">
                                            🔄 {{ $supplier->status === 'active' ? 'Off' : 'On' }}
                                        </button>
                                    @endcan
                                    
                                    @can('suppliers.delete')
                                        <button onclick="confirmDelete({{ $supplier->id }}, '{{ $supplier->name }}')"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs"
                                                style="background-color: #ef4444 !important; color: white !important; padding: 4px 8px !important; border-radius: 4px !important; border: none !important; cursor: pointer !important; display: inline-block !important; visibility: visible !important;"
                                                title="Delete Supplier">
                                            🗑️ Delete
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                No suppliers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>

<script>
function confirmDelete(supplierId, supplierName) {
    if (confirm('Are you sure you want to delete the supplier "' + supplierName + '"? This action cannot be undone.')) {
        @this.call('deleteSupplier', supplierId);
    }
}
</script>
