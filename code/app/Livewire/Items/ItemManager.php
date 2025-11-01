<?php

namespace App\Livewire\Items;

use App\Models\Item;
use App\Models\UOM;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class ItemManager extends Component
{
    use WithPagination;

    // Search and filters
    public $search = '';
    public $typeFilter = '';
    public $activeFilter = '';
    
    // Modal states
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    
    // Item data
    public $selectedItem = null;
    public $itemId = '';
    public $name = '';
    public $sku = '';
    public $internal_reference = '';
    public $description = '';
    public $type = 'product';
    public $default_uom_id = '';
    public $purchase_uom_id = '';
    public $sale_uom_id = '';
    public $list_price = '';
    public $cost_price = '';
    public $weight = '';
    public $volume = '';
    public $can_be_sold = true;
    public $can_be_purchased = true;
    public $can_be_tracked = false;
    public $track_by_lots = false;
    public $track_by_serial = false;
    public $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'sku' => 'nullable|string|max:100',
        'internal_reference' => 'nullable|string|max:100',
        'description' => 'nullable|string',
        'type' => 'required|in:product,service,consumable',
        'default_uom_id' => 'required|exists:uoms,id',
        'purchase_uom_id' => 'nullable|exists:uoms,id',
        'sale_uom_id' => 'nullable|exists:uoms,id',
        'list_price' => 'nullable|numeric|min:0',
        'cost_price' => 'nullable|numeric|min:0',
        'weight' => 'nullable|numeric|min:0',
        'volume' => 'nullable|numeric|min:0',
        'can_be_sold' => 'boolean',
        'can_be_purchased' => 'boolean',
        'can_be_tracked' => 'boolean',
        'track_by_lots' => 'boolean',
        'track_by_serial' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingActiveFilter()
    {
        $this->resetPage();
    }

    #[Computed]
    public function items()
    {
        $query = Item::with(['defaultUom', 'purchaseUom', 'saleUom']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'ILIKE', "%{$this->search}%")
                  ->orWhere('sku', 'ILIKE', "%{$this->search}%")
                  ->orWhere('description', 'ILIKE', "%{$this->search}%")
                  ->orWhere('internal_reference', 'ILIKE', "%{$this->search}%");
            });
        }

        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }

        if ($this->activeFilter !== '') {
            $query->where('is_active', $this->activeFilter === '1');
        }

        return $query->orderBy('name')->paginate(10);
    }

    #[Computed]
    public function uoms()
    {
        return UOM::orderBy('name')->get();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function openEditModal($itemId)
    {
        $item = Item::findOrFail($itemId);
        $this->selectedItem = $item;
        
        $this->itemId = $item->id;
        $this->name = $item->name;
        $this->sku = $item->sku;
        $this->internal_reference = $item->internal_reference;
        $this->description = $item->description;
        $this->type = $item->type;
        $this->default_uom_id = $item->default_uom_id;
        $this->purchase_uom_id = $item->purchase_uom_id;
        $this->sale_uom_id = $item->sale_uom_id;
        $this->list_price = $item->list_price;
        $this->cost_price = $item->cost_price;
        $this->weight = $item->weight;
        $this->volume = $item->volume;
        $this->can_be_sold = $item->can_be_sold;
        $this->can_be_purchased = $item->can_be_purchased;
        $this->can_be_tracked = $item->can_be_tracked;
        $this->track_by_lots = $item->track_by_lots;
        $this->track_by_serial = $item->track_by_serial;
        $this->is_active = $item->is_active;
        
        $this->showEditModal = true;
    }

    public function openDeleteModal($itemId)
    {
        $this->selectedItem = Item::findOrFail($itemId);
        $this->showDeleteModal = true;
    }

    public function createItem()
    {
        $this->rules['sku'] = 'nullable|string|max:100|unique:items,sku';
        $this->validate();

        Item::create([
            'name' => $this->name,
            'sku' => $this->sku ?: null,
            'internal_reference' => $this->internal_reference ?: null,
            'description' => $this->description ?: null,
            'type' => $this->type,
            'default_uom_id' => $this->default_uom_id,
            'purchase_uom_id' => $this->purchase_uom_id ?: null,
            'sale_uom_id' => $this->sale_uom_id ?: null,
            'list_price' => $this->list_price ?: null,
            'cost_price' => $this->cost_price ?: null,
            'weight' => $this->weight ?: null,
            'volume' => $this->volume ?: null,
            'can_be_sold' => $this->can_be_sold,
            'can_be_purchased' => $this->can_be_purchased,
            'can_be_tracked' => $this->can_be_tracked,
            'track_by_lots' => $this->track_by_lots,
            'track_by_serial' => $this->track_by_serial,
            'is_active' => $this->is_active,
        ]);

        $this->showCreateModal = false;
        $this->resetForm();
        $this->dispatch('item-created');
        session()->flash('message', __('items.item_created_successfully'));
    }

    public function updateItem()
    {
        $this->rules['sku'] = 'nullable|string|max:100|unique:items,sku,' . $this->itemId;
        $this->validate();

        $this->selectedItem->update([
            'name' => $this->name,
            'sku' => $this->sku ?: null,
            'internal_reference' => $this->internal_reference ?: null,
            'description' => $this->description ?: null,
            'type' => $this->type,
            'default_uom_id' => $this->default_uom_id,
            'purchase_uom_id' => $this->purchase_uom_id ?: null,
            'sale_uom_id' => $this->sale_uom_id ?: null,
            'list_price' => $this->list_price ?: null,
            'cost_price' => $this->cost_price ?: null,
            'weight' => $this->weight ?: null,
            'volume' => $this->volume ?: null,
            'can_be_sold' => $this->can_be_sold,
            'can_be_purchased' => $this->can_be_purchased,
            'can_be_tracked' => $this->can_be_tracked,
            'track_by_lots' => $this->track_by_lots,
            'track_by_serial' => $this->track_by_serial,
            'is_active' => $this->is_active,
        ]);

        $this->showEditModal = false;
        $this->resetForm();
        $this->dispatch('item-updated');
        session()->flash('message', __('items.item_updated_successfully'));
    }

    public function deleteItem()
    {
        try {
            $this->selectedItem->delete();
            $this->showDeleteModal = false;
            $this->dispatch('item-deleted');
            session()->flash('message', __('items.item_deleted_successfully'));
        } catch (\Exception $e) {
            session()->flash('error', __('items.cannot_delete_item'));
        }
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->selectedItem = null;
        $this->itemId = '';
        $this->name = '';
        $this->sku = '';
        $this->internal_reference = '';
        $this->description = '';
        $this->type = 'product';
        $this->default_uom_id = '';
        $this->purchase_uom_id = '';
        $this->sale_uom_id = '';
        $this->list_price = '';
        $this->cost_price = '';
        $this->weight = '';
        $this->volume = '';
        $this->can_be_sold = true;
        $this->can_be_purchased = true;
        $this->can_be_tracked = false;
        $this->track_by_lots = false;
        $this->track_by_serial = false;
        $this->is_active = true;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.items.item-manager');
    }
}
