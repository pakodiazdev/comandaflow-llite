<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">
                {{ $supplier->id ? 'Edit Supplier' : 'Create Supplier' }}
            </h2>
            <a href="{{ route('suppliers.index') }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                Back to Suppliers
            </a>
        </div>

        <form wire:submit="save" class="space-y-6">
            <!-- Basic Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Supplier Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               wire:model="name" 
                               id="name"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Enter supplier name">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Contact Person -->
                    <div>
                        <label for="contact_person" class="block text-sm font-medium text-gray-700 mb-1">
                            Contact Person
                        </label>
                        <input type="text" 
                               wire:model="contact_person" 
                               id="contact_person"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Enter contact person name">
                        @error('contact_person') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               wire:model="email" 
                               id="email"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Enter email address">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                            Phone
                        </label>
                        <input type="text" 
                               wire:model="phone" 
                               id="phone"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Enter phone number">
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Website -->
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-1">
                            Website
                        </label>
                        <input type="url" 
                               wire:model="website" 
                               id="website"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="https://example.com">
                        @error('website') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tax ID -->
                    <div>
                        <label for="tax_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Tax ID
                        </label>
                        <input type="text" 
                               wire:model="tax_id" 
                               id="tax_id"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Enter tax identification number">
                        @error('tax_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Address Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                            Address
                        </label>
                        <textarea wire:model="address" 
                                  id="address"
                                  rows="3"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Enter street address"></textarea>
                        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">
                            City
                        </label>
                        <input type="text" 
                               wire:model="city" 
                               id="city"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Enter city">
                        @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- State -->
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 mb-1">
                            State/Province
                        </label>
                        <input type="text" 
                               wire:model="state" 
                               id="state"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Enter state or province">
                        @error('state') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">
                            Postal Code
                        </label>
                        <input type="text" 
                               wire:model="postal_code" 
                               id="postal_code"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Enter postal code">
                        @error('postal_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Country -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">
                            Country <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="country" 
                                id="country"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="US">United States</option>
                            <option value="CA">Canada</option>
                            <option value="MX">Mexico</option>
                            <option value="GB">United Kingdom</option>
                            <option value="DE">Germany</option>
                            <option value="FR">France</option>
                            <option value="IT">Italy</option>
                            <option value="ES">Spain</option>
                            <option value="AU">Australia</option>
                            <option value="JP">Japan</option>
                            <option value="CN">China</option>
                            <option value="BR">Brazil</option>
                        </select>
                        @error('country') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Business Terms -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Business Terms</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="status" 
                                id="status"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="suspended">Suspended</option>
                        </select>
                        @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Credit Limit -->
                    <div>
                        <label for="credit_limit" class="block text-sm font-medium text-gray-700 mb-1">
                            Credit Limit ($)
                        </label>
                        <input type="number" 
                               wire:model="credit_limit" 
                               id="credit_limit"
                               step="0.01"
                               min="0"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="0.00">
                        @error('credit_limit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Payment Terms -->
                    <div>
                        <label for="payment_terms" class="block text-sm font-medium text-gray-700 mb-1">
                            Payment Terms (days) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               wire:model="payment_terms" 
                               id="payment_terms"
                               min="0"
                               max="365"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="30">
                        @error('payment_terms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Notes</h3>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                        Notes
                    </label>
                    <textarea wire:model="notes" 
                              id="notes"
                              rows="4"
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                              placeholder="Enter any additional notes about this supplier"></textarea>
                    @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('suppliers.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                    {{ $supplier->id ? 'Update Supplier' : 'Create Supplier' }}
                </button>
            </div>
        </form>
    </div>
</div>
