<?php

include '../../app/Mage.php';
Mage::app('admin');

// This script is currently only written to create simple products
$number_of_categories_created = 202;
$number_of_products_to_create = 100;
$max_categories_per_product = 6;

include 'utilities/Terms.php';
include 'utilities/Url.php';
include 'utilities/Permute.php';
include 'utilities/Product.php';
$termsHelper = new DLS_Utility_Helper_Terms();
$permuteHelper = new DLS_Utility_Helper_Permute();

$product_term_adjectives = array("Green", "Blue", "Red", "Black", "White", "American", "Euro", "Asian", "Brown", "Musical", "Bright", "Dark", "Comical", "Business", "Casual", "Plain");
$product_term_nouns = array("Loafer", "Sneaker", "Boot", "Sandal", "Flip-flop", "Polo", "Button-Up", "T-Shirt", "Tank-top", "Dress", "Khakis", "Capris", "Jeans", "Sweatpants", "Necklace", "Ring", "Bracelet", "Earrings", "Song", "Album", "String", "Horn", "Trumpet", "Guitar", "Piano", "Bat", "Glove", "Spike", "Stick", "Bag", "Mouse", "USB", "HD", "HDMI", "LCD", "LED", "Plasma", "Television", "Radio", "Movie", "DVD", "CD", "MP3", "Laptop", "Desktop", "Lamp", "Brick", "Anchor", "Mens", "Womens", "Child", "Toddler", "Baby");

$productHelper = new DLS_Utility_Helper_Product();
$eavEntityType = Mage::getModel('eav/entity_type')->loadByCode('catalog_product');
$default_attribute_set_id = $eavEntityType->getDefaultAttributeSetId();

$default_store_id = 1;
$simple_product_type = 'simple';
$max_weight = 100;
$max_price = 300;

// TODO Do this a better way
$category_ids_array = array();

for ($cat_count = 3; $cat_count <= $number_of_categories_created; $cat_count++)
{
    $category_ids_array[] = $cat_count;
}

$number_of_categories = count($category_ids_array);

$simple_product_data_array = array(
    'attribute_set_id' => $default_attribute_set_id,
    'type_id' => $simple_product_type,
    'website_ids' => array($default_store_id),
    'news_from_date' => '',
    'news_to_date' => '',
    'status' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED,
    'visibility' => Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
    'country_of_manufacture' => '',
    'special_price' => '',
    'special_from_date' => '',
    'msrp_enabled' => '2',
    'msrp_display_actual_price_type' => '4',
    'msrp' => '',
    'enable_googlecheckout' => '1',
    'tax_class_id' => '0',
    'image' => 'no_selection',
    'small_image' => 'no_selection',
    'thumbnail' => 'no_selection',
    'media_gallery' => array(
        'images' => '[]',
        'values' => '{"image":null,"small_image":null,"thumbnail":null}'
    ),
    'is_recurring' => '0',
    'recurring_profile' => '',
    'custom_design' => '',
    'custom_design_from' => '',
    'custom_design_to' => '',
    'custom_layout_update' => '',
    'page_layout' => '',
    'options_container' => 'container2',
    'use_config_gift_message_available' => '1',
    'can_save_configurable_attributes' => false,
    'can_save_custom_options' => false,
    'can_save_bundle_selections' => false
);

for($p = 0; $p < $number_of_products_to_create; $p++)
{
    $specific_product_data_to_add = $simple_product_data_array;
    // Generate random product name
    $name_adjective = $termsHelper->getRandomTermFromList($product_term_adjectives, 1);
    $name_noun = $termsHelper->getRandomTermFromList($product_term_nouns, 1);
    $name = $name_adjective .' ' . $name_noun;
    $specific_product_data_to_add['name'] = $name;
    $specific_product_data_to_add['description'] = $name;
    $specific_product_data_to_add['short_description'] = $name;
    $specific_product_data_to_add['meta_title'] = $name;
    $specific_product_data_to_add['meta_keyword'] = $name;
    $specific_product_data_to_add['meta_description'] = $name;
    $product_sku = str_replace(' ', '-', $name);
    $permuted_product_sku = $permuteHelper->getPermutedValue($product_sku, 'sku');

    $specific_product_data_to_add['sku'] = $permuted_product_sku;
    $specific_product_data_to_add['url_key'] = $permuted_product_sku;
    $random_weight = rand(1, $max_weight);
    $specific_product_data_to_add['weight'] = $random_weight;
    $specific_product_data_to_add['price'] = rand(1, $max_price);

    // Need to generate a list of category ids to add the product to
    $num_categories_to_add_product_to = rand(1,($max_categories_per_product));
    $product_category_ids_string = $termsHelper->getRandomTermFromList(
                            $category_ids_array, $num_categories_to_add_product_to, ',');

    $product_category_ids_array = explode(',', $product_category_ids_string);
    $specific_product_data_to_add['category_ids'] = $product_category_ids_array;

    $product = $productHelper->createProductObject($specific_product_data_to_add, $default_store_id);
    $product->save();

    echo "$p products created\n";
}