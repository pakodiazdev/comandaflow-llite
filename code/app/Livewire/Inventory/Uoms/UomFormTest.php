<?php

namespace App\Livewire\Inventory\Uoms;

use App\Models\Uom;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class UomFormTest extends Component
{
    public ?Uom $uom = null;
    public string $code = '';
    public string $name = '';

    public function mount(?Uom $uom = null)
    {
        Log::info('UomFormTest component loaded');
        
        if ($uom) {
            Log::info('UomFormTest: Edit mode', ['uom_id' => $uom->id]);
            $this->uom = $uom;
            $this->code = $uom->code ?? '';
            $this->name = $uom->name ?? '';
        } else {
            Log::info('UomFormTest: Create mode');
            $this->uom = null;
            $this->code = '';
            $this->name = '';
        }
    }

    public function save()
    {
        Log::info('UomFormTest save() called', [
            'route' => request()->route()->getName(),
            'has_uom' => $this->uom ? 'yes' : 'no',
            'uom_id' => $this->uom?->id ?? 'null',
            'code' => $this->code,
            'name' => $this->name
        ]);

        if (empty($this->code) || empty($this->name)) {
            session()->flash('error', 'Code and name are required');
            return;
        }

        try {
            if ($this->uom && $this->uom->exists) {
                Log::info('UomFormTest: Updating');
                $this->uom->update([
                    'code' => $this->code,
                    'name' => $this->name,
                ]);
                $message = 'UOM updated successfully!';
            } else {
                Log::info('UomFormTest: Creating');
                $this->uom = Uom::create([
                    'code' => $this->code,
                    'name' => $this->name,
                ]);
                $message = 'UOM created successfully!';
            }

            session()->flash('success', $message);
            return redirect()->route('uoms.index');
        } catch (\Exception $e) {
            Log::error('UomFormTest: Error', ['error' => $e->getMessage()]);
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        Log::info('UomFormTest render() called');
        return view('livewire.inventory.uoms.uom-form-test');
    }
}