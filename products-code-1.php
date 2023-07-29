<?php


use Drupal\taxonomy\Entity\Term;

function get_csv_file_1() {
  
  $view = \Drupal\views\Views::getView('practice_products_fields_get_csv');
  $view->setDisplay('default');
  $view->execute();
  $view_result = $view->result;
  print($view_result);
 
  // Check if the view is not empty and return results.
  if (!empty($view_result)) {
    // Create an array to store the CSV data
    $csv_data = array();
      
    foreach ($view->result as $id => $result) {
      $node = $result->_entity;
      // print_r($node);
      // get data by machine names
      $Body = $node->get('body')->value;

      $CTA_Action = $node->get('field_ydp_cta_action')->value;

      $CTA_Label = $node->get('field_ydp_cta_label')->value;

      $Features = $node->get('field_ydp_feature')->value;

      // $Image = $node->get('field_ydp_image')->value;
      $imageField = $node->get('field_ydp_image')->first();
            $imageUrl = '';
            if (!empty($imageField)) {
                $imageEntity = $imageField->entity;
                if (!empty($imageEntity)) {
                
                $ImageUrl = file_create_url($imageEntity->getFileUri());
                
                }
                
            }
    
      $IsFeatured = $node->get('field_ydp_is_featured')->value;

      $PriceCaption = $node->get('field_ydp_price_caption')->value;

      $ProductCategorytermID = $node->get('field_ydp_category')->getString();
      $term = Term::load($ProductCategorytermID);
      $ProductCategorytermName = $term->getName();
      
      $ProductsOrder = $node->get('field_products_order')->value;
      
      $Show_fullpage = $node->get('field_ydp_show_fullpage')->value;

      // Add the data to the CSV array
      $csv_data[] = array(
        $Body,
        $CTA_Action,
        $CTA_Label,
        $Features,
        $ImageUrl,
        $IsFeatured,
        $PriceCaption,
        $ProductCategorytermName,
        $ProductsOrder,
        $Show_fullpage 

      );  
    }

    // Generate the CSV file
    // $csv_file_path = 'path/to/your/csv_file.csv';
    $csv_file_path = 'C:/xampp/htdocs/yep/pract-scripts/products-fields-csv-8.csv';
    $csv_file = fopen($csv_file_path, 'w');

    // Write the CSV header
    fputcsv($csv_file, array('Body','CTA_Action','CTA_Label', 
     'Features','Image','IsFeatured','PriceCaption','ProductCategorytermName','ProductsOrder','Show_fullpage'));

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
