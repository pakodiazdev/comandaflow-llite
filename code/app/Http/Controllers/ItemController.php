<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Uom;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Item::with(['defaultUom']);

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('sku', 'ILIKE', "%{$search}%")
                  ->orWhere('notes', 'ILIKE', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->has('type') && $request->type !== '') {
            $query->where('type', $request->type);
        }

        // Filter by stocked status
        if ($request->has('stocked') && $request->stocked !== '') {
            $query->where('is_stocked', $request->stocked === '1');
        }

        $items = $query->orderBy('name')
                      ->paginate(15)
                      ->withQueryString();

        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $uoms = Uom::orderBy('name')->get();
        
        return view('items.create', compact('uoms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:items,sku',
            'notes' => 'nullable|string',
            'type' => 'required|in:INSUMO,PRODUCTO,ACTIVO',
            'default_uom_id' => 'required|exists:uoms,id',
            'selling_price' => 'nullable|numeric|min:0',
            'is_stocked' => 'boolean',
            'is_perishable' => 'boolean',
            'has_variants' => 'boolean',
        ]);

        $item = Item::create($validated);

        return redirect()->route('items.show', $item)
                        ->with('success', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item): View
    {
        $item->load(['defaultUom', 'variants']);
        
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item): View
    {
        $uoms = Uom::orderBy('name')->get();
        
        return view('items.edit', compact('item', 'uoms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:items,sku,' . $item->id,
            'notes' => 'nullable|string',
            'type' => 'required|in:INSUMO,PRODUCTO,ACTIVO',
            'default_uom_id' => 'required|exists:uoms,id',
            'selling_price' => 'nullable|numeric|min:0',
            'is_stocked' => 'boolean',
            'is_perishable' => 'boolean',
            'has_variants' => 'boolean',
        ]);

        $item->update($validated);

        return redirect()->route('items.show', $item)
                        ->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item): RedirectResponse
    {
        try {
            $item->delete();
            
            return redirect()->route('items.index')
                            ->with('success', 'Item deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('items.index')
                            ->with('error', 'Cannot delete item: it may be referenced by other records.');
        }
    }
}