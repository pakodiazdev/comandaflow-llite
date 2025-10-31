<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $supplier->name }}</h1>
                <div class="mt-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $supplier->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($supplier->status) }}
                    </span>
                </div>
            </div>
            <div class="flex space-x-3">
                @can('suppliers.update')
                    <a href="{{ route('suppliers.edit', $supplier) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Edit
                    </a>
                @endcan
                <a href="{{ route('suppliers.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to List
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Contact Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                <dl class="space-y-3">
                    @if($supplier->contact_person)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Contact Person</dt>
                            <dd class="text-sm text-gray-900">{{ $supplier->contact_person }}</dd>
                        </div>
                    @endif
                    @if($supplier->email)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="text-sm text-gray-900">
                                <a href="mailto:{{ $supplier->email }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $supplier->email }}
                                </a>
                            </dd>
                        </div>
                    @endif
                    @if($supplier->phone)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="text-sm text-gray-900">
                                <a href="tel:{{ $supplier->phone }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $supplier->phone }}
                                </a>
                            </dd>
                        </div>
                    @endif
                    @if($supplier->website)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Website</dt>
                            <dd class="text-sm text-gray-900">
                                <a href="{{ $supplier->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                    {{ $supplier->website }}
                                </a>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Business Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Business Information</h3>
                <dl class="space-y-3">
                    @if($supplier->tax_id)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tax ID</dt>
                            <dd class="text-sm text-gray-900">{{ $supplier->tax_id }}</dd>
                        </div>
                    @endif
                    @if($supplier->business_type)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Business Type</dt>
                            <dd class="text-sm text-gray-900">{{ ucfirst($supplier->business_type) }}</dd>
                        </div>
                    @endif
                    @if($supplier->payment_terms)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Payment Terms</dt>
                            <dd class="text-sm text-gray-900">{{ $supplier->payment_terms }}</dd>
                        </div>
                    @endif
                    @if($supplier->lead_time_days)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Lead Time</dt>
                            <dd class="text-sm text-gray-900">{{ $supplier->lead_time_days }} days</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Address Information -->
        @if($supplier->address || $supplier->city || $supplier->state || $supplier->postal_code || $supplier->country)
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Address</h3>
                <div class="text-sm text-gray-900">
                    @if($supplier->address)
                        <div>{{ $supplier->address }}</div>
                    @endif
                    <div class="flex space-x-2">
                        @if($supplier->city)
                            <span>{{ $supplier->city }}</span>
                        @endif
                        @if($supplier->state)
                            <span>{{ $supplier->state }}</span>
                        @endif
                        @if($supplier->postal_code)
                            <span>{{ $supplier->postal_code }}</span>
                        @endif
                    </div>
                    @if($supplier->country)
                        <div>{{ $supplier->country }}</div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Description -->
        @if($supplier->description)
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>
                <p class="text-sm text-gray-900">{{ $supplier->description }}</p>
            </div>
        @endif

        <!-- Products -->
        @if($supplier->products->count() > 0)
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Associated Products</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($supplier->products as $product)
                        <div class="bg-white p-3 rounded border">
                            <div class="font-medium text-gray-900">{{ $product->name }}</div>
                            @if($product->pivot->price)
                                <div class="text-sm text-gray-600">Price: ${{ number_format($product->pivot->price, 2) }}</div>
                            @endif
                            @if($product->pivot->lead_time_days)
                                <div class="text-sm text-gray-600">Lead time: {{ $product->pivot->lead_time_days }} days</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Timestamps -->
        <div class="mt-6 pt-4 border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-gray-500">
                <div>
                    <span class="font-medium">Created:</span> {{ $supplier->created_at->format('M d, Y \a\t g:i A') }}
                </div>
                <div>
                    <span class="font-medium">Last Updated:</span> {{ $supplier->updated_at->format('M d, Y \a\t g:i A') }}
                </div>
            </div>
        </div>
    </div>
</div>
