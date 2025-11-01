<?php

return [
    // Page titles
    'items' => 'Items',
    'item' => 'Item',
    'manage_items' => 'Manage Items',
    'product_catalog' => 'Product Catalog',
    'new_item' => 'New Item',
    'create_item' => 'Create Item',
    'edit_item' => 'Edit Item',
    'item_details' => 'Item Details',
    'delete_item' => 'Delete Item',
    
    // Item types
    'producto' => 'Product',
    'insumo' => 'Supply',
    'activo' => 'Asset',
    'product' => 'Product',
    'service' => 'Service',
    'consumable' => 'Consumable',
    'all_types' => 'All Types',
    
    // Item fields
    'sku' => 'SKU',
    'internal_reference' => 'Internal Reference',
    'list_price' => 'List Price',
    'cost_price' => 'Cost Price',
    'weight' => 'Weight',
    'volume' => 'Volume',
    'default_uom' => 'Default Unit of Measure',
    'purchase_uom' => 'Purchase UOM',
    'sale_uom' => 'Sale UOM',
    'selling_price' => 'Selling Price',
    'is_stocked' => 'Is Stocked',
    'is_perishable' => 'Is Perishable',
    'no_stock' => 'No Stock',
    
    // Item configuration
    'can_be_sold' => 'Can be sold',
    'can_be_purchased' => 'Can be purchased',
    'can_be_tracked' => 'Track inventory',
    'track_by_lots' => 'Track by lots',
    'track_by_serial' => 'Track by serial number',
    'is_active' => 'Active',
    
    // Form sections
    'basic_information' => 'Basic Information',
    'units_pricing' => 'Units & Pricing',
    'physical_properties' => 'Physical Properties',
    'configuration' => 'Configuration',
    'sales_purchase' => 'Sales & Purchase',
    'tracking' => 'Tracking',
    
    // Table headers
    'item_name' => 'Item',
    'item_type' => 'Type',
    'uom' => 'UOM',
    'prices' => 'Prices',
    'sale_price' => 'Sale',
    'cost' => 'Cost',
    
    // Placeholders
    'enter_item_name' => 'Enter item name',
    'enter_sku' => 'Enter SKU',
    'enter_internal_reference' => 'Enter internal reference',
    'enter_item_description' => 'Enter item description',
    'select_uom' => 'Select UOM',
    'search_placeholder' => 'Name, SKU, description...',
    
    // Units
    'kg' => 'kg',
    'm3' => 'm³',
    
    // Filter options
    'all_status' => 'All Status',
    
    // Messages
    'item_created_successfully' => 'Item created successfully.',
    'item_updated_successfully' => 'Item updated successfully.',
    'item_deleted_successfully' => 'Item deleted successfully.',
    'cannot_delete_item' => 'Cannot delete item: it may be referenced by other records.',
    'no_items_found' => 'No items found.',
    'confirm_delete_item' => 'Are you sure you want to delete',
    
    // Validation
        // Validation messages
    'name_required' => 'The name is required.',
    'sku_unique' => 'The SKU is already in use.',
    'sku_format' => 'The SKU can only contain letters, numbers, hyphens and underscores.',
    'invalid_type' => 'The selected type is invalid.',
    'default_uom_required' => 'The default unit of measure is required.',
    'invalid_uom' => 'The selected unit of measure is invalid.',
    'positive_number' => 'Must be a positive number.',
    'price_too_high' => 'The price is too high.',
    'has_variants' => 'Has Variants',
];