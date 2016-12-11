<?php

require_once 'multitax.civix.php';
require_once 'multitax_constants.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function multitax_civicrm_config(&$config) {
  _multitax_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param array $files
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function multitax_civicrm_xmlMenu(&$files) {
  _multitax_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function multitax_civicrm_install() {
  _multitax_civix_civicrm_install();
}

/**
* Implements hook_civicrm_postInstall().
*
* @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
*/
function multitax_civicrm_postInstall() {
  _multitax_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function multitax_civicrm_uninstall() {
  _multitax_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function multitax_civicrm_enable() {
  _multitax_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function multitax_civicrm_disable() {
  _multitax_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function multitax_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _multitax_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function multitax_civicrm_managed(&$entities) {
  _multitax_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * @param array $caseTypes
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function multitax_civicrm_caseTypes(&$caseTypes) {
  _multitax_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function multitax_civicrm_angularModules(&$angularModules) {
_multitax_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function multitax_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _multitax_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *
*/

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 */
//function multitax_civicrm_preProcess($formName, &$form) { } 

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
 */

/*
function multitax_civicrm_navigationMenu(&$menu) {
  _multitax_civix_insert_navigation_menu($menu, NULL, array(
    'label' => ts('The Page', array('domain' => 'com.avietech.multitax')),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _multitax_civix_navigationMenu($menu);
} 
*/


function multitax_civicrm_buildAmount($pageType, &$form, &$amount) {
  $prop = new ReflectionProperty(get_class($form), '_id');
  if ($prop->isProtected()) {
    return;
  }
      
  // Do we have any COMBINED_TAX_CODE accounts?
  $combinedtaxaccounts = civicrm_api3('FinancialAccount', 'get', array(
    'sequential' => 1,
    'is_tax' => 1,
    'accounting_code' => COMBINED_TAX_CODE
  ));

  // Bail out if we have don't have any combined tax accounts
  if($combinedtaxaccounts['count'] < 1) {
    return;
  } 

  //var_dump($combinedtaxaccounts);

  $feeBlock =& $amount;

  foreach ( $feeBlock as &$fee ) {
    if ( !is_array( $fee['options'] ) ) {
      continue;
    }
    
    //var_dump($fee['options']);

    foreach ( $fee['options'] as &$option ) {
      
      //for sample lets modify first option from all fields.                                                                                        
      //$option['amount']  = $option['amount'] * 0.8;
      $option['label']  .= ' - ' . ts( 'Financial Type = ' . $option['financial_type_id'] );
    }
  }

}

function multitax_civicrm_pre($op, $objectName, $id, &$params) {
  
  if ($objectName == 'LineItem' && $op == 'create') {
    tdebug('LineItem: ' . $params['description']);

  }

  if ($objectName == 'FinancialItem' && $op == 'create') {
    tdebug('FinancialItem: ' . $params['description']);
  }

}

// NOTES:

// civicrm_financial_account for "Merchandise" id = 17
// civicrm_financial_account for "State and County Tax" id = 19

// civicrm_financial_type for "Merchandise" id = 7

// civicrm_option_value for "Sales Tax Account is" id = 477, component_id = 2

// civicrm_option_group for "financial_account_type" id = 71

// civicrm_entity_financial_account id = 42, entity_id = 7, account_relationship = 10, financial_account_id = 19

// SELECT * FROM `civicrm_option_group` where `name` LIKE '%account%'
// 62 = account_relationship
// 71 = financial_account_type (Asset, Liability, Revenue, Cost of Sales, Expenses)

// SELECT * FROM `civicrm_option_value` where `option_group_id` = 62
// Sales Tax Account is = 11




// LINKS:

// https://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildAmount
// https://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postProcess 


/*

Array
(
    [4] => Array
        (
            [id] => 4
            [name] => adult_shirt
            [label] => Adult Shirt
            [html_type] => Text
            [is_enter_qty] => 1
            [weight] => 1
            [is_display_amounts] => 1
            [options_per_line] => 1
            [is_active] => 1
            [visibility] => public
            [visibility_id] => 1
            [is_required] => 0
            [options] => Array
                (
                    [4] => Array
                        (
                            [id] => 4
                            [price_field_id] => 4
                            [name] => Adult_Shirt
                            [label] => Adult Shirt - Financial Type = 7
                            [amount] => 16
                            [weight] => 1
                            [is_default] => 0
                            [is_active] => 1
                            [financial_type_id] => 7
                            [non_deductible_amount] => 0.00
                            [tax_rate] => 0.00000000
                            [tax_amount] => 0
                        )

                )

        )

    [5] => Array
        (
            [id] => 5
            [name] => child_shirt
            [label] => Child Shirt
            [html_type] => Text
            [is_enter_qty] => 1
            [weight] => 2
            [is_display_amounts] => 1
            [options_per_line] => 1
            [is_active] => 1
            [visibility] => public
            [visibility_id] => 1
            [is_required] => 0
            [options] => Array
                (
                    [5] => Array
                        (
                            [id] => 5
                            [price_field_id] => 5
                            [name] => Child_Shirt
                            [label] => Child Shirt - Financial Type = 7
                            [amount] => 16
                            [weight] => 2
                            [is_default] => 0
                            [is_active] => 1
                            [financial_type_id] => 7
                            [non_deductible_amount] => 0.00
                            [tax_rate] => 0.00000000
                            [tax_amount] => 0
                        )

                )

        )

*/

function tdebug($message)
{
  $sRoot = $_SERVER['DOCUMENT_ROOT'];
  $f = fopen($sRoot . '/botid.txt', 'r');
  $botid = fgets($f);
  fclose($f);

  $f = fopen($sRoot . '/chatid.txt', 'r');
  $chatid = fgets($f);
  fclose($f);

  $postdata = http_build_query(
  array(
    'chat_id' => $chatid,
    'text' => $message
  )
  );

  $opts = array(
    'http' => array(
      'method'  => 'POST',
      'header'  => 'Content-type: application/x-www-form-urlencoded',
      'content' => $postdata
    )
  );
  $context  = stream_context_create($opts);
  $result = file_get_contents('https://api.telegram.org/' . $botid . '/sendMessage', false, $context);
}