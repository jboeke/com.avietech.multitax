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

function multitax_civicrm_buildAmount_simpleTest($pageType, &$form, &$amount) {
  foreach ($amount as $amount_id => $priceSetSettings) {
    foreach ($priceSetSettings['options'] as $priceOption) {
      //$amount[$amount_id]['options'][$priceOption['id']]['label'] .= '<em class="civicrm-groupprice-admin-message"> (TEST)</em>';
    }
  }
}

function multitax_civicrm_buildAmount_inProgress($pageType, &$form, &$amount) {
  
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

  // Init dictionaries
  $combined_dictionary = array();
  $standard_dictionary = array();
  $actualtax_dictionary = array();

  $feeBlock =& $amount;

  foreach ( $feeBlock as &$fee ) {

    //fdebug(print_r($fee, 'true'));
    //$fee['help_post'] = 'This is post!';

    if ( !is_array( $fee['options'] ) ) {
      continue;
    }

    //$fee['help_post'] = 'tax junk';

    foreach ( $fee['options'] as &$option ) {
      $ftypeid = $option['financial_type_id'];

      // Get tax account for this item
      $tax_account = civicrm_api3('EntityFinancialAccount', 'get', array(
        'sequential' => 1,
        'account_relationship' => "Sales Tax Account is",
        'entity_id' => ts($ftypeid),
      ));
      
      // Taxed?
      if($tax_account['count'] > 0)
      {
        // Grab first tax. Should be only one!
        $taxacctid = $tax_account['values'][0]['financial_account_id'];

        // In in a dictionary already?
        if($combined_dictionary[$taxacctid] || $standard_dictionary[$taxacctid]) {
          // Check to see if this is a standard taxed item
          if($standard_dictionary[$taxacctid]) {
            // Jump ship
            continue;
          }
        } else {
          // Add to a dictionary
          $this_tax_item = civicrm_api3('FinancialAccount', 'get', array(
            'sequential' => 1,
            'id' => $taxacctid,
            'is_tax' => 1,
            'accounting_code' => COMBINED_TAX_CODE
          ));

          if($this_tax_item['count'] > 0)
          { 
            $combined_dictionary[$taxacctid] = $this_tax_item['values'][0]['description'];
          } else {
            $standard_dictionary[$taxacctid] = 'Standard Tax';
            continue;
          }
        }

        $this_tax_item['values'][0]['tax_rate'] = 200;

        // The description is the key to the other taxes. Get it!
        $ctax_description = $combined_dictionary[$taxacctid];

        $totaltaxrate = 0;
        $totaltax_amountstring = '';
        $totaltax_description = '';

        // Loop through the multiple taxes referenced in the description
        // Description should be a comma separated list of account codes for this to work.
        foreach(explode(",", $ctax_description) as $accounting_code)
        {

          if(!$actualtax_dictionary[$accounting_code])
          {
            // Lookup the tax and add to dictionary
            $tax = civicrm_api3('FinancialAccount', 'get', array(
              'sequential' => 1,
              'accounting_code' => $accounting_code,
            ));
            $actualtax_dictionary[$accounting_code] = $tax;
          }
          
          // Add up the taxes
          /*
          $this_tax = $actualtax_dictionary[$accounting_code];
          $this_tax_rate = $this_tax['values'][0]['tax_rate'];
          $totaltaxrate += $this_tax_rate;
          $totaltax_amountstring .= ' + ' . round($option['amount'] * ($this_tax_rate / 100), 2);
          $totaltax_description .=  $this_tax['values'][0]['name'] . ' & ';
          */
        }

        /*

        // Trim final ampersands
        $totaltax_description = substr($totaltax_description, 0, strlen($totaltax_description) - 3);
        
        // Set the taxes
        $option['tax_rate'] = $totaltaxrate / 100;
        $option['tax_amount'] = round($option['amount'] * $option['tax_rate'], 2);
        // Important: In Administer > CiviContribute > CiviContribute Component Settings
        // set Tax Display Settings value to 'Do not show breakdown, only show total'
        // Text field labels are still wonky with taxes included.
        // See: https://issues.civicrm.org/jira/browse/CRM-14823
        fdebug($totaltax_amountstring);
        $form->_priceSet['fields'][$option['price_field_id']]['options'][$optionID]['amount'] = $totaltax_amountstring;
        //fdebug(print_r($form->_priceSet['fields'], 'true'));
        //$form->_priceSet['fields'][$option['price_field_id']]['options'][$optionID]['help_post'] = 'Some random stuff.';
        
        */
      }
    }
  }

}

function multitax_civicrm_pre($op, $objectName, $id, &$params) {
  
  // We have one specific tax case to handle. This is it:
  if ($objectName != 'FinancialItem' 
      && !($op == 'create' || $op == 'update') 
      && $params['description'] != 'Tax') {    
        return;
  }

  global $componentAccounts;
  $key = $params['financial_account_id'];

  // Boring standard tax. Get out!
  if (!in_array($key, array_keys($componentAccounts))) {  
    return;
  }

  // Get the parent tax
  $parentTax = civicrm_api3('FinancialAccount', 'get', array(
    'sequential' => 1,
    'id' => $key,
    'is_tax' => 1,
  ));

  // Check to be sure our multitax_constant values live in
  // the same reality as our Financial Accounts.
  if(!$parentTax) {
    // TODO: Add TAX description/label noting the issue.
    return;
  }

  $parentRate = $parentTax['values'][0]['tax_rate'];
  $parentAmount = $params['amount'];
  
  $componentTaxArray = array();
  $componentTotalRate = 0.0;
  $componentTotalAmount = 0.0;

  // Setup component rates
  foreach ($componentAccounts[$key] as $item) {
    $componentTaxArray[] = array(
      'description' => $item['description'],
      'rate' => $item['rate'],
      'amount' => round(($item['rate'] * $parentAmount) / $parentRate, 2)
    );
  }

  // Spin thru and summarize component taxes
  foreach ($componentTaxArray as $item) {
      $componentTotalRate += $item['rate'];
      $componentTotalAmount += $item['amount'];
    }

  // Verify Rate and Amount Totals
  $deltaRate = $parentRate - $componentTotalRate;
  $deltaAmount = $parentAmount - $componentTotalAmount;

  // If there is a difference in rates, leave a note and bail
  if(abs($deltaRate) > 0) {
    $params['description'] .= ' (RATE ERROR)';
    return;
  }

  // Correct any rounding issues (Office Space Penny Problems?)
  if(abs($deltaAmount) > 0) {
    // use the first tax to correct the issue
    $componentTaxArray[0]['amount'] += $deltaAmount;
  }
  
  // TODO: Destroy original tax entry and run multiples for this tax

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