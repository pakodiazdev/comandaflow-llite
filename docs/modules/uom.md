# UOM (Units of Measure) Module

## 📖 Overview
The UOM module provides standardized units of measurement for inventory items in ComandaFlow Lite. This module allows users to define and manage units like pieces (`pz`), boxes (`caja`), packs (`pack`), etc.

## 🗃️ Database Structure

### `uoms` Table
- `id` - Primary key (auto-increment)
- `code` - Unique string identifier (max 16 chars, e.g., `pz`, `caja`, `pack`)
- `name` - Human-readable name (max 64 chars, e.g., `Pieza`, `Caja`, `Pack`)
- `created_at` - Timestamp when record was created
- `updated_at` - Timestamp when record was last updated

### Indexes
- Primary key on `id`
- Unique index on `code`
- Regular index on `code` for performance

## 🧠 Model: `App\Models\Uom`

### Mass Assignable Fields
```php
protected $fillable = ['code', 'name'];
```

### Available Scopes
- `scopeSearch($query, $term)` - Search by code or name using LIKE pattern

### Example Usage
```php
// Find all UOMs
$uoms = Uom::all();

// Search UOMs
$uoms = Uom::search('pz')->get();

// Create new UOM
$uom = Uom::create([
    'code' => 'kg',
    'name' => 'Kilogramo'
]);
```

## ⚡ Livewire Components

### `UomsIndex` - Listing and Management
- **Location**: `app/Livewire/Inventory/Uoms/UomsIndex.php`
- **View**: `resources/views/livewire/inventory/uoms/uoms-index.blade.php`
- **Features**:
  - Paginated listing (15 items per page)
  - Real-time search by code or name
  - Delete functionality with confirmation
  - Responsive design with Tailwind CSS

### `UomForm` - Create/Edit Form
- **Location**: `app/Livewire/Inventory/Uoms/UomForm.php`
- **View**: `resources/views/livewire/inventory/uoms/uom-form.blade.php`
- **Features**:
  - Single component for create and edit operations
  - Real-time validation
  - Flash messages for success/error feedback

## 🧭 Routes

```php
// Protected by auth middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/inventory/uoms', UomsIndex::class)->name('uoms.index');
    Route::get('/inventory/uoms/{uom?}', UomForm::class)->name('uoms.form');
});
```

## ✅ Validation Rules

### Code Field
- Required
- String (max 16 characters)
- Alpha-dash only (letters, numbers, dashes, underscores)
- Must be unique in the `uoms` table

### Name Field
- Required
- String (max 64 characters)

## 🌱 Default Data
The seeder (`UomSeeder`) creates these default units:
- `pz` → `Pieza`
- `caja` → `Caja`
- `pack` → `Pack`

## 🧪 Testing
Use the factory to generate test data:
```php
// Create a single UOM
$uom = Uom::factory()->create();

// Create multiple UOMs
$uoms = Uom::factory()->count(10)->create();
```

## 🔗 Integration
This module is ready to be referenced by other modules through foreign keys:
```php
// In Item/Product migration
$table->foreignId('default_uom_id')->constrained('uoms');
```

## 🎯 Future Enhancements
- Unit conversion system
- Compound units (e.g., boxes containing pieces)
- Import/export functionality
- API endpoints for external integrations