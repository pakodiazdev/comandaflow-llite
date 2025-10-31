<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class SupplierForm extends Component
{
    public $supplier;
    public $name = '';
    public $contact_person = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $city = '';
    public $state = '';
    public $country = 'US';
    public $postal_code = '';
    public $tax_id = '';
    public $website = '';
    public $notes = '';
    public $status = 'active';
    public $credit_limit = '';
    public $payment_terms = 30;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'required|email|unique:suppliers,email,' . ($this->supplier->id ?? null),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:2',
            'postal_code' => 'nullable|string|max:20',
            'tax_id' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive,suspended',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_terms' => 'required|integer|min:0|max:365',
        ];
    }

    public function mount($supplier = null)
    {
        if ($supplier) {
            $this->supplier = $supplier;
            $this->fill([
                'name' => $supplier->name,
                'contact_person' => $supplier->contact_person,
                'email' => $supplier->email,
                'phone' => $supplier->phone,
                'address' => $supplier->address,
                'city' => $supplier->city,
                'state' => $supplier->state,
                'country' => $supplier->country,
                'postal_code' => $supplier->postal_code,
                'tax_id' => $supplier->tax_id,
                'website' => $supplier->website,
                'notes' => $supplier->notes,
                'status' => $supplier->status,
                'credit_limit' => $supplier->credit_limit,
                'payment_terms' => $supplier->payment_terms,
            ]);
        } else {
            $this->supplier = new Supplier();
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'contact_person' => $this->contact_person,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'postal_code' => $this->postal_code,
            'tax_id' => $this->tax_id,
            'website' => $this->website,
            'notes' => $this->notes,
            'status' => $this->status,
            'credit_limit' => $this->credit_limit ?: null,
            'payment_terms' => $this->payment_terms,
        ];

        if ($this->supplier->id) {
            $this->supplier->update($data);
            session()->flash('success', 'Supplier updated successfully.');
        } else {
            Supplier::create($data);
            session()->flash('success', 'Supplier created successfully.');
        }

        return redirect()->route('suppliers.index');
    }

    public function render()
    {
        return view('livewire.suppliers.supplier-form');
    }
}
