<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Basic Information -->
    <div class="space-y-4">
        <h4 class="text-md font-medium text-gray-900">{{ __('items.basic_information') }}</h4>
        
        <!-- Name -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.name') }} *</label>
            <input 
                type="text" 
                wire:model="name"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                placeholder="{{ __('items.enter_item_name') }}"
            >
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- SKU -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('items.sku') }}</label>
            <input 
                type="text" 
                wire:model="sku"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('sku') border-red-500 @enderror"
                placeholder="{{ __('items.enter_sku') }}"
            >
            @error('sku') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Type -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.type') }} *</label>
            <select 
                wire:model="type"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('type') border-red-500 @enderror"
            >
                <option value="PRODUCTO">{{ __('items.producto') }}</option>
                <option value="INSUMO">{{ __('items.insumo') }}</option>
                <option value="ACTIVO">{{ __('items.activo') }}</option>
            </select>
            @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Description/Notes -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('app.description') }}</label>
            <textarea 
                wire:model="description"
                rows="3"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                placeholder="{{ __('items.enter_item_description') }}"
            ></textarea>
            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    </div>

    <!-- UOM and Pricing -->
    <div class="space-y-4">
        <h4 class="text-md font-medium text-gray-900">{{ __('items.units_pricing') }}</h4>
        
        <!-- Default UOM -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('items.default_uom') }} *</label>
            <select 
                wire:model="default_uom_id"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('default_uom_id') border-red-500 @enderror"
            >
                <option value="">{{ __('items.select_uom') }}</option>
                @foreach($this->uoms as $uom)
                    <option value="{{ $uom->id }}">{{ $uom->name }}</option>
                @endforeach
            </select>
            @error('default_uom_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Selling Price -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('items.selling_price') }}</label>
            <input 
                type="number" 
                step="0.01"
                wire:model="list_price"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('list_price') border-red-500 @enderror"
                placeholder="0.00"
            >
            @error('list_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Configuration Options -->
        <div class="space-y-3">
            <h4 class="text-md font-medium text-gray-900">{{ __('items.configuration') }}</h4>
            
            <label class="flex items-center">
                <input 
                    type="checkbox" 
                    wire:model="can_be_tracked"
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                <span class="ml-2 text-sm text-gray-700">{{ __('items.is_stocked') }}</span>
            </label>

            <label class="flex items-center">
                <input 
                    type="checkbox" 
                    wire:model="track_by_lots"
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                <span class="ml-2 text-sm text-gray-700">{{ __('items.is_perishable') }}</span>
            </label>
        </div>
    </div>
</div>