<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SupplierList extends Component
{
    use WithPagination, AuthorizesRequests;

    public $search = '';
    public $status = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function deleteSupplier($supplierId)
    {
        try {
            // Check authorization
            $this->authorize('suppliers.delete');
            
            $supplier = Supplier::find($supplierId);
            
            if (!$supplier) {
                session()->flash('error', 'Supplier not found.');
                return;
            }
            
            // Check if supplier has products
            if ($supplier->products()->count() > 0) {
                session()->flash('error', 'Cannot delete supplier with associated products. Please remove all products first.');
                return;
            }
            
            $supplierName = $supplier->name;
            $supplier->delete();
            
            session()->flash('success', "Supplier '{$supplierName}' has been deleted successfully.");
            
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the supplier. Please try again.');
        }
    }

    public function toggleStatus($supplierId)
    {
        // Check authorization
        $this->authorize('suppliers.update');
        
        $supplier = Supplier::find($supplierId);
        
        if ($supplier) {
            $supplier->status = $supplier->status === 'active' ? 'inactive' : 'active';
            $supplier->save();
            
            session()->flash('success', 'Supplier status updated successfully.');
        }
    }

    public function render()
    {
        $suppliers = Supplier::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('contact_person', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.suppliers.supplier-list', [
            'suppliers' => $suppliers,
        ]);
    }
}
