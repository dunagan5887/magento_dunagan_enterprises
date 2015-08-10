<?php

include '../../app/Mage.php';
include 'utilities/Category.php';
include 'utilities/Url.php';
include 'utilities/Terms.php';
Mage::app('admin');

$category_count = 200;
$default_store_id = 1;

$categoryHelper = new  DLS_Utility_Helper_Category();
$termsHelper = new DLS_Utility_Helper_Terms();

$category_terms = array("Shoes", "Shirts", "Pants", "Suits", "Clothes", "Jewelry", "Stuff", "Things", "Music", "Instruments", "Sports", "Baseball", "Basketball", "Football", "Hockey", "Guitars", "Pianos", "Drums", "Bass", "Hats", "Computers", "Keyboards", "Monitors", "Sean", "Brendan");
$subterms_per_term = 3;

$number_of_terms = count($category_terms);

$created_category_paths = array();
$created_category_ids = array();

$admin_store_root_category_path = $categoryHelper->getStoreRootCategoryPath($default_store_id);
$created_category_paths[] = $admin_store_root_category_path;

$created_category_url_keys = array();

for($c = 0; $c < $category_count; $c++)
{
    $random_category_name = $termsHelper->getRandomTermFromList($category_terms, $subterms_per_term);

    $number_of_created_category_paths = count($created_category_paths);
    $random_category_path_index = rand(0, ($number_of_created_category_paths - 1));
    // Should always be set, but check just in case
    $category_path = isset($created_category_paths[$random_category_path_index])
                        ? $created_category_paths[$random_category_path_index] : reset($number_of_created_category_paths);

    $category_data = array(
        'name' => $random_category_name,
        'description' => $random_category_name,
        'meta_title' => $random_category_name,
        'meta_description' => $random_category_name,
        'meta_keywords' => $random_category_name,
        'is_active' => 1,
        'include_in_menu' => 1,
        'path' => $category_path
    );
    $categoryObject = $categoryHelper->createCategoryObject($category_data, $default_store_id);
    $categoryObject->save();

    $created_category_ids[] = $categoryObject->getId();
    $created_category_paths[] = $categoryObject->getPath();
}

$created_category_ids_string = implode(',', $created_category_ids);
file_put_contents('./logs/created_category_ids.log', $created_category_ids_string);

