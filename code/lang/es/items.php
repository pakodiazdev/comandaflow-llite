<?php

return [
    // Page titles
    'items' => 'Artículos',
    'item' => 'Artículo',
    'manage_items' => 'Gestionar Artículos',
    'product_catalog' => 'Catálogo de Productos',
    'new_item' => 'Nuevo Artículo',
    'create_item' => 'Crear Artículo',
    'edit_item' => 'Editar Artículo',
    'item_details' => 'Detalles del Artículo',
    'delete_item' => 'Eliminar Artículo',
    
    // Item types
    'product' => 'Producto',
    'service' => 'Servicio',
    'consumable' => 'Consumible',
    'all_types' => 'Todos los Tipos',
    
    // Item fields
    'sku' => 'SKU',
    'internal_reference' => 'Referencia Interna',
    'list_price' => 'Precio de Lista',
    'cost_price' => 'Precio de Costo',
    'weight' => 'Peso',
    'volume' => 'Volumen',
    'default_uom' => 'Unidad de Medida Predeterminada',
    'purchase_uom' => 'Unidad de Compra',
    'sale_uom' => 'Unidad de Venta',
    
    // Item configuration
    'can_be_sold' => 'Se puede vender',
    'can_be_purchased' => 'Se puede comprar',
    'can_be_tracked' => 'Seguimiento de inventario',
    'track_by_lots' => 'Seguimiento por lotes',
    'track_by_serial' => 'Seguimiento por número de serie',
    'is_active' => 'Activo',
    
    // Form sections
    'basic_information' => 'Información Básica',
    'units_pricing' => 'Unidades y Precios',
    'physical_properties' => 'Propiedades Físicas',
    'configuration' => 'Configuración',
    'sales_purchase' => 'Ventas y Compras',
    'tracking' => 'Seguimiento',
    
    // Table headers
    'item_name' => 'Artículo',
    'item_type' => 'Tipo',
    'uom' => 'Unidad',
    'prices' => 'Precios',
    'sale_price' => 'Precio Venta',
    'cost' => 'Costo',
    
    // Placeholders
    'enter_item_name' => 'Ingresa el nombre del artículo',
    'enter_sku' => 'Ingresa el SKU',
    'enter_internal_reference' => 'Ingresa la referencia interna',
    'enter_item_description' => 'Ingresa la descripción del artículo',
    'select_uom' => 'Selecciona UOM',
    'search_placeholder' => 'Nombre, SKU, descripción...',
    
    // Units
    'kg' => 'kg',
    'm3' => 'm³',
    
    // Filter options
    'all_status' => 'Todos los Estados',
    
    // Messages
    'item_created_successfully' => 'Artículo creado exitosamente.',
    'item_updated_successfully' => 'Artículo actualizado exitosamente.',
    'item_deleted_successfully' => 'Artículo eliminado exitosamente.',
    'cannot_delete_item' => 'No se puede eliminar el artículo: puede estar referenciado por otros registros.',
    'no_items_found' => 'No se encontraron artículos.',
    'confirm_delete_item' => '¿Estás seguro de que deseas eliminar',
    
    // Validation
    'name_required' => 'El nombre es obligatorio.',
    'sku_unique' => 'El SKU ya está en uso.',
    'default_uom_required' => 'La unidad de medida predeterminada es obligatoria.',
    'positive_number' => 'Debe ser un número positivo.',
];