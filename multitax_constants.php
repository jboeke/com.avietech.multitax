<?php

// Use CTAX for the Account Type Code of the Parent Financial Account.
// Put the Accounting Codes for the Child taxes in the Description of the Parent.
// Both Parent and Child tax Financial Accounts should have isTax marked true.
// Tax Rate of the Child Accounts must add up to the Tax Rate of the Parent Financial Account.

define('COMBINED_TAX_CODE', 'CTAX');
