<?php

namespace App\Livewire\Inventory\Uoms;

use App\Models\Uom;
use Livewire\Component;
use Livewire\WithPagination;

class UomsIndex extends Component
{
    use WithPagination;

    public string $search = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($uomId)
    {
        $uom = Uom::findOrFail($uomId);
        $uom->delete();
        session()->flash('success', 'UOM eliminado correctamente.');
    }

    public function render()
    {
        $uoms = Uom::when($this->search, function ($query) {
            $query->search($this->search);
        })->orderBy('code')->paginate(15);

        return view('livewire.inventory.uoms.uoms-index', [
            'uoms' => $uoms,
        ]);
    }
}