<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class SupplierShow extends Component
{
    public Supplier $supplier;

    public function mount(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

    public function render()
    {
        return view('livewire.suppliers.supplier-show');
    }
}
