<?php

namespace App\Livewire\Inventory\Uoms;

use App\Models\Uom;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class UomForm extends Component
{
    public ?Uom $uom = null;
    public string $code = '';
    public string $name = '';

    public function mount(?Uom $uom = null)
    {
        // Immediate log to confirm component is loading
        Log::info('UomForm component loaded');
        
        // Debug: Check what we're receiving
        Log::info('UomForm mount called', [
            'uom_passed' => $uom ? 'UOM object passed' : 'null passed',
            'uom_id' => $uom?->id ?? 'null',
            'uom_exists' => $uom?->exists ?? 'null',
            'current_route' => request()->route() ? request()->route()->getName() : 'no route',
            'current_url' => request()->url()
        ]);
        
        // Only set uom if it actually exists in the database
        if ($uom && $uom->exists) {
            $this->uom = $uom;
            $this->code = $uom->code ?? '';
            $this->name = $uom->name ?? '';
            Log::info('UomForm mount: Set edit mode', [
                'code' => $this->code,
                'name' => $this->name
            ]);
        } else {
            // Ensure we're in create mode - ignore passed uom if it doesn't exist
            $this->uom = null;
            $this->code = '';
            $this->name = '';
            Log::info('UomForm mount: Set create mode');
        }
    }

    protected function rules()
    {
        $uomId = $this->uom?->id;
        
        return [
            'code' => $uomId 
                ? "required|string|max:16|alpha_dash|unique:uoms,code,{$uomId}" 
                : 'required|string|max:16|alpha_dash|unique:uoms,code',
            'name' => 'required|string|max:64',
        ];
    }

    protected $validationAttributes = [
        'code' => 'código',
        'name' => 'nombre',
    ];

    public function save()
    {
        Log::info('UomForm save() called', [
            'current_route' => request()->route()->getName(),
            'uom_state' => $this->uom ? 'has uom object' : 'uom is null',
            'uom_id' => $this->uom?->id ?? 'null',
            'uom_exists' => $this->uom?->exists ?? 'null',
            'code' => $this->code,
            'name' => $this->name
        ]);

        $this->validate([
            'code' => 'required|unique:uoms,code' . ($this->uom && $this->uom->exists ? ',' . $this->uom->id : ''),
            'name' => 'required|string|max:255',
        ]);

        try {
            if ($this->uom && $this->uom->exists) {
                Log::info('UomForm: Updating existing UOM', ['id' => $this->uom->id]);
                // Update
                $this->uom->update([
                    'code' => $this->code,
                    'name' => $this->name,
                ]);
                $message = 'UOM updated successfully!';
            } else {
                Log::info('UomForm: Creating new UOM');
                // Create
                $this->uom = Uom::create([
                    'code' => $this->code,
                    'name' => $this->name,
                ]);
                $message = 'UOM created successfully!';
            }

            session()->flash('success', $message);
            
            Log::info('UomForm: Operation completed successfully', [
                'final_uom_id' => $this->uom->id,
                'operation' => $this->uom->wasRecentlyCreated ? 'create' : 'update'
            ]);

            return redirect()->route('uoms.index');
        } catch (\Exception $e) {
            Log::error('UomForm: Error during save', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Error saving UOM: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.inventory.uoms.uom-form');
    }
}