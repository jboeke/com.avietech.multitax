<?php

require_once 'multitax.civix.php';
require_once 'multitax_constants.php';
require_once 'avietech_debug.php';

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

function multitax_civicrm_pre($op, $objectName, $id, &$params) {

  // We have one specific tax case to handle. This is it:
  if (!($objectName == 'FinancialItem' 
      && ($op == 'create' || $op == 'update') 
      && substr($params['description'], 0, 3) == 'Tax')) {
        return;
  }

  $key = $params['financial_account_id'];

  // Get the parent tax
  $parentTax = civicrm_api3('FinancialAccount', 'get', array(
    'sequential' => 1,
    'id' => $key,
    'is_tax' => 1,
    'account_type_code' => COMBINED_TAX_CODE
  ));

  // Boring standard tax. Get out!
  if(!$parentTax) {
    return;
  }

  // Parent Account description must be a comma separated list of accounting codes
  $accountingCodeList = explode(",", $parentTax['values'][0]['description']);

  $parentRate = $parentTax['values'][0]['tax_rate'];
  $parentAmount = $params['amount'];
  $childTaxArray = array();

  // Check parent rate
  if(!$parentRate || $parentRate <= 0) {
    $params['description'] .= ' (Multitax: Parent Rate Error)';
    return;
  }

  // Loop through the child tax accounts
  foreach($accountingCodeList as $acctCode) {

    $childTax = civicrm_api3('FinancialAccount', 'get', array(
      'sequential' => 1,
      'accounting_code' => $acctCode,
      'is_tax' => 1,
    ));

    // Child not found or not a tax. Notify and halt.
    if(!$childTax) {
      $params['description'] .= ' (Multitax: Child Tax Error)';
      return;
    }

    $childTaxArray[] = array(
      'name' => $childTax['values'][0]['name'],
      'description' => $childTax['values'][0]['description'],
      'tax_rate' => $childTax['values'][0]['tax_rate'],
      'amount' => round(($childTax['values'][0]['tax_rate'] * $parentAmount) / $parentRate, 2)
    );

  }
  
  $childTotalRate = 0.0;
  $childTotalAmount = 0.0;

  // Spin thru and summarize child taxes
  foreach ($childTaxArray as $item) {
      $childTotalRate += $item['tax_rate'];
      $childTotalAmount += $item['amount'];
  }

  // Verify Rate and Amount Totals
  $deltaRate = $parentRate - $childTotalRate;
  $deltaAmount = $parentAmount - $childTotalAmount;

  // If there is a difference in rates, leave a note and bail
  if(abs($deltaRate) > 0) {
    $params['description'] .= ' (Multitax: Rate Match Error)';
    return;
  }

  // Correct any rounding issues
  if(abs($deltaAmount) > 0) {
    // Use the first tax to correct the issue
    $childTaxArray[0]['amount'] += $deltaAmount;
  }
  
  // TODO: Destroy original tax entry and run multiples for this tax
  $params['description'] = 'Tax: ';
  foreach ($childTaxArray as $item) {
    $params['description'] .= $item['name'] . ' (' . $item['amount'] . ') + ';  
  }

  // Trim final Plus
  $params['description'] = substr($params['description'], 0, strlen($params['description']) - 3);

}

///////////
// NOTES //
///////////

/* 

civicrm_financial_account for "Merchandise" id = 17
civicrm_financial_account for "State and County Tax" id = 19

civicrm_financial_type for "Merchandise" id = 7

civicrm_option_value for "Sales Tax Account is" id = 477, component_id = 2

civicrm_option_group for "financial_account_type" id = 71

civicrm_entity_financial_account id = 42, entity_id = 7, account_relationship = 10, financial_account_id = 19

SELECT * FROM `civicrm_option_group` where `name` LIKE '%account%'
62 = account_relationship
71 = financial_account_type (Asset, Liability, Revenue, Cost of Sales, Expenses)

SELECT * FROM `civicrm_option_group` where id=62
name = account_relationship

SELECT * FROM `civicrm_option_value` WHERE `label` like '%sales tax account%'
value = 10

*/


///////////
// LINKS //
///////////

// Projects:

// https://github.com/dlobo/org.civicrm.module.cividiscount/blob/master/cividiscount.php
// https://github.com/TechToThePeople/group2summary/blob/ajax/group2summary.php

// HOOKS:

// https://wiki.civicrm.org/confluence/display/CRMDOC/Hook+Reference

// https://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildAmount
// https://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postProcess