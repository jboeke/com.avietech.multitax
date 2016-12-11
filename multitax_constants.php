<?php

// This is the accounting_code you will use for a combined tax.
define('COMBINED_TAX_CODE', 'CTAX');

// Sales Tax Account ID: Hopefully this will not need adjusting.
// Just in case, here's help finding it.

// SELECT * FROM `civicrm_option_group` where id=62
// name = account_relationship

// SELECT * FROM `civicrm_option_value` WHERE `label` like '%sales tax account%'
// value = 10
define('SALES_TAX_ACCOUNT_ID', 10);

// In Financial Accounts, set the description to a list of tax accounting_code values you wish to combine.
// Those not flagged is_tax will be ignored.
// e.g. - {"2241", "2242"}
// The tax_rate value for any combined financial account entries will be ignored.
// It is recommended to set tax_rate for them to 0.