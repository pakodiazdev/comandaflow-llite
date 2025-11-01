# 📏 Create UOM (Units of Measure) Module
## 📖 Story
As a developer, I need a complete **UOM (Units of Measure)** module to standardize how items are quantified (e.g., *pz*, *caja*, *pack*) so that the inventory can consistently record quantities and later reference these units from **Items**.

---

## ✅ Technical Tasks

- [ ] 🗃️ **Migration:** `database/migrations/**_create_uoms_table.php`
  - Table: `uoms`
  - Columns:
    - `id` **bigIncrements** (primary, auto-increment)
    - `code` string(16) **unique** (e.g., `pz`, `caja`, `pack`)
    - `name` string(64) (e.g., `Pieza`, `Caja`, `Pack`)
    - `created_at`, `updated_at`
  - Index: unique on `code`.

- [ ] 🧠 **Model:** `app/Models/Uom.php`
  - `$fillable = ['code', 'name']`
  - Scopes:
    - `scopeSearch($q, $term)` → search by `code` or `name`.

- [ ] 🏭 **Factory:** `database/factories/UomFactory.php`
  - Generates short `code` and readable `name` for tests.

- [ ] 🌱 **Seeder:** `database/seeders/UomSeeder.php`
  - Seeds defaults:
    - `pz` → `Pieza`
    - `caja` → `Caja`
    - `pack` → `Pack`

- [ ] ⚡ **Livewire CRUD (v3)**
  - Folder: `app/Livewire/Inventory/Uoms/`
    - `UomsIndex.php` → list with search + pagination + New/Edit/Delete
    - `UomForm.php` → create/edit form (fields: code, name)
  - Views: `resources/views/livewire/inventory/uoms/`
    - `uoms-index.blade.php`
    - `uom-form.blade.php`
  - Validation:
    - `code`: `required|string|max:16|alpha_dash|unique:uoms,code,{ignoreId}`
    - `name`: `required|string|max:64`

- [ ] 🧭 **Routes:** `routes/web.php` (inside `auth` group)
  ```php
  Route::middleware('auth')->group(function () {
      Route::get('/inventory/uoms', App\Livewire\Inventory\Uoms\UomsIndex::class)->name('uoms.index');
      Route::get('/inventory/uoms/{uom?}', App\Livewire\Inventory\Uoms\UomForm::class)->name('uoms.form');
  });
  ```
  > Add policies/permissions later; for MVP, auth-only is OK.

- [ ] 🧪 **Tests (optional)**:
  - `tests/Feature/UomCrudTest.php`: create, avoid duplicate code, update, delete.
  - `tests/Unit/UomModelTest.php`: fillable & search scope.

- [ ] 🧾 **Docs:** `/docs/modules/uom.md`
  - Purpose, fields, validations, example usage from Livewire.

---

## 🧪 Acceptance Criteria
- Can **list, create, edit, delete** UOMs from the UI (Livewire).
- Validation prevents duplicate `code`.
- `UomSeeder` populated defaults (`pz`, `caja`, `pack`).
- Ready to reference from `Items.default_uom_id` (int FK).

---

## 🧩 Implementation Notes (for Copilot)
- Laravel 12 + Livewire 3 (page components).
- Keep Tailwind UI minimal (table + form).
- Pagination 10–20 rows, search on `code`/`name`.
- `UomForm` handles create vs edit via optional route param `{uom?}`.
- Use `session()->flash('ok', '...')` after create/update.

---

## ⏱️ Time
### 📊 Estimates
- **Optimistic:** `1h 30m`
- **Pessimistic:** `3h`
- **Tracked:** `0h 00m`

### 📅 Sessions
```json
[
  {"date": "2025-10-30", "start": "19:50", "end": "20:20"},
  {"date": "2025-10-31", "start": "18:50", "end": "21:00"}
]
```

---

## Commit Message for Issue #UOM-01
```
📏 [#UOM-01] feat(uoms): create Units of Measure module (Laravel 12 + Livewire)

- Migration with auto-increment PK and unique code
- Model, Factory, Seeder (defaults: pz, caja, pack)
- Livewire CRUD (index + form) with validation and Tailwind UI
- Routes protected under auth
- Ready to be referenced by Items.default_uom_id
```
