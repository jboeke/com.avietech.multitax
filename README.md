# com.avietech.multitax

*WARNING! [This code uses the civicrm_api3 'create' function to create a new 'EntityFinancialTrxn'](https://github.com/jboeke/com.avietech.multitax/blob/master/multitax.php#L312). 
The CiviCRM team recommends a through review by their team before publishing this code to civicrm.org*

## Overview

A CiviCRM Extension for the purpose of storing taxes in individual components. 

In the case where you might have a city and state tax, you'll need to report on both.

## Instructions

![Screenshot](/screenshot1.png?raw=true)

1) Create all individual taxes as you [normally would in CiviCRM](https://docs.civicrm.org/user/en/4.6/contributions/sales-tax-and-vat/). In my screenshot, these are "County Tax" and "State Tax".

2) Create a parent tax to be the vehicle for your individual child taxes. In my screenshot, this is "State and County Tax."

3) The parent tax Account Type must specifically be "CTAX" unless you change the [COMBINED_TAX_CODE](https://github.com/jboeke/com.avietech.multitax/blob/master/multitax.php#L11) variable in the code.

4) Use the parent tax Description to create a comma separated list of the Accounting Codes you wish to be the child taxes for this parent. (NOTE: NO spaces.)

5) Upon saving an event, the parent tax will be decomposed into its child elements in the civicrm_financial_item table.


## Notes

All Accounting Codes for parent and child taxes must be unique for this extension to work.

This is only designed and tested for Events at the moment.

The only other option is to change [USE_TAX_DESCRIPTION](https://github.com/jboeke/com.avietech.multitax/blob/master/multitax.php#L12) if you wish to use the tax description instead of the tax name in the description field of the civicrm_financial_item table.
