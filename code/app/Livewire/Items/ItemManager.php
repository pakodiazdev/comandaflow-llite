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
    
    // DEPRECATED: Remove after sessions clear (backwards compatibility)
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
    public $description = '';
    public $type = 'PRODUCTO';
    public $default_uom_id = '';
    public $list_price = '';
    public $can_be_tracked = false;
    public $track_by_lots = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'sku' => 'nullable|string|max:100',
        'description' => 'nullable|string',
        'type' => 'required|in:INSUMO,PRODUCTO,ACTIVO',
        'default_uom_id' => 'required|exists:uoms,id',
        'list_price' => 'nullable|numeric|min:0',
        'can_be_tracked' => 'boolean',
        'track_by_lots' => 'boolean',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function mount()
    {
        // Initialize properties to ensure clean state
        $this->search = '';
        $this->typeFilter = '';
        
        // Reset any cached Livewire state
        $this->resetPage();
    }

    /**
     * Handle setting of non-existent properties (for backwards compatibility)
     */
    public function __set($name, $value)
    {
        // Ignore attempts to set deprecated properties
        if (in_array($name, ['activeFilter'])) {
            return;
        }
        
        // Call parent for other properties
        parent::__set($name, $value);
    }

    public function updatingActiveFilter()
    {
        // DEPRECATED: Handle cached sessions, do nothing
    }

    #[Computed]
    public function items()
    {
        $query = Item::with(['defaultUom']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'ILIKE', "%{$this->search}%")
                  ->orWhere('sku', 'ILIKE', "%{$this->search}%")
                  ->orWhere('notes', 'ILIKE', "%{$this->search}%");
            });
        }

        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
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
        $this->description = $item->notes;
        $this->type = $item->type;
        $this->default_uom_id = $item->default_uom_id;
        $this->list_price = $item->selling_price;
        $this->can_be_tracked = $item->is_stocked;
        $this->track_by_lots = $item->is_perishable;

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
            'type' => $this->type,
            'default_uom_id' => $this->default_uom_id,
            'selling_price' => $this->list_price ?: null,
            'notes' => $this->description ?: null,
            'is_stocked' => $this->can_be_tracked ?? true,
            'is_perishable' => $this->track_by_lots ?? false,
            'has_variants' => false,
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
            'type' => $this->type,
            'default_uom_id' => $this->default_uom_id,
            'selling_price' => $this->list_price ?: null,
            'notes' => $this->description ?: null,
            'is_stocked' => $this->can_be_tracked ?? true,
            'is_perishable' => $this->track_by_lots ?? false,
            'has_variants' => false,
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
        $this->description = '';
        $this->type = 'PRODUCTO';
        $this->default_uom_id = '';
        $this->list_price = '';
        $this->can_be_tracked = false;
        $this->track_by_lots = false;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.items.item-manager');
    }
}
