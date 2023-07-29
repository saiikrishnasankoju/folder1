<?php


use Drupal\taxonomy\Entity\Term;
use Drupal\commerce_product\Entity\ProductVariation;
function get_csv_file_1() {
  
  $view = \Drupal\views\Views::getView('practice_products_variations_fields_get_csv_');
  $view->setDisplay('default');
  $view->execute();
  $view_result = $view->result;
//   print($view_result);
 
  // Check if the view is not empty and return results.
  if (!empty($view_result)) {
    // Create an array to store the CSV data
    $csv_data = array();
      
    foreach ($view->result as $id => $result) {
      $node = $result->_entity;
      // print_r($node);
      // get data by machine names
    //  $Bundle = $node->get('field_bundle')->value; 
      $variationID =  $node->get('field_bundle')->getString();
    //   var_dump($variationID);
    //   print($variationID);
      $variation = ProductVariation::load($variationID);

      if(empty($variation)){
     
        $sku='';
      }
       else{
        $sku = $variation->getSku();
       }


    $Description = $node->get('field_ydp_desc')->value;

    //   $Image = $node->get('field_ydp_image')->value;
    $imageField = $node->get('field_ydp_image')->first();
    $imageUrl = '';
    if (!empty($imageField)) {
        $imageEntity = $imageField->entity;

        if (!empty($imageEntity)) {
        
        $ImageUrl = file_create_url($imageEntity->getFileUri());
        
        }
        
    }
      $PriceUnit = $node->get('field_price_name')->value;
      $ShowBuyNow = $node->get('field_show_buy_now')->value;
      $Specification = $node->get('field_ydp_spec')->value;
      $Subscriptionplan = $node->get('field_subscription_plan')->value;
      
      
    //   $PriceUnit = $view->style_plugin->getFieldValue($id, 'field_price_name');
    //   $ProductCategorytermID = $node->get('field_ydp_category')->getString();
    //   $term = Term::load($ProductCategorytermID);
    //   $ProductCategorytermName = $term->getName();

      // $Subscription_Plan = $node->get('field_subscription_plan')->value;
    //   $Subscription_Plan =$view->style_plugin->getFieldValue($id, 'field_subscription_plan');
    //   $Image = $node->get('field_ydp_image')->value;
      // $Description = $node->get('field_ydp_desc')->value;
      // $Description = $view->style_plugin->getFieldValue($id, 'field_ydp_desc');
    //   $IsFeatured = $node->get('field_ydp_is_featured')->value;
    //   $Features = $node->get('field_ydp_feature')->value;
    //   // $ShowBuyNow = $node->get('field_show_buy_now')->value;
    //   // $ShowBuyNow =  $view->style_plugin->getFieldValue($id, 'field_show_buy_now');
    //   $CTA_Action = $node->get('field_ydp_cta_action')->value;
    //   $CTA_Label = $node->get('field_ydp_cta_label')->value;
    //   $Show_fullpage = $node->get('field_ydp_show_fullpage')->value;

      // Add the data to the CSV array
      $csv_data[] = array(
        $sku,
        $Description,
        $ImageUrl,
        $PriceUnit,
        $ShowBuyNow,
        $Specification,
        $Subscriptionplan
      );  
    }

    // Generate the CSV file
    // $csv_file_path = 'path/to/your/csv_file.csv';
    $csv_file_path = 'C:/xampp/htdocs/yep/pract-scripts/variations-csv-21.csv';
    $csv_file = fopen($csv_file_path, 'w');

    // Write the CSV header
    fputcsv($csv_file, array('sku','Description','ImageUrl', 
     'PriceUnit',/*'Description'*/'ShowBuyNow','Specification'/*'ShowBuyNow'*/,'Subscriptionplan'));

    // Write the data to the CSV file
    foreach ($csv_data as $row) {
      fputcsv($csv_file, $row);
    }

    // Close the CSV file
    fclose($csv_file);

    echo "CSV file created successfully!";
  } else {
    echo "View Is Not Exist";
  }
}

get_csv_file_1();
?>
