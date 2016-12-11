<?php

// This is the accounting_code you will use for a combined tax.
define('COMBINED_TAX_CODE', 'CTAX');

// In Financial Accounts, set the description to a list of tax accounting_code values you wish to combine.
// Those not flagged is_tax will be ignored.
// e.g. - {"2241", "2242"}
// The tax_rate value for any combined financial account entries will be ignored.
// It is recommended to set tax_rate for them to 0.