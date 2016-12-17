# com.avietech.multitax

*WARNING! This code uses the civicrm_api3 'create' function to create a new 'EntityFinancialTrxn'. 
The CiviCRM team recommends a through review by their team before publishing this code to civicrm.org*

## Overview

A CiviCRM Extension for the purpose of storing taxes in individual components. 

In the case where you might have a city and state tax, you'll need to report on both.

## Instructions

![Screenshot](/screenshot1.png?raw=true)

1) Create all individual taxes as you [normally would in CiviCRM](https://docs.civicrm.org/user/en/4.6/contributions/sales-tax-and-vat/). In my screenshot, these are "County Tax" and "State Tax".

2) Create a Parent Tax to be the vehicle for your individual Child taxes. In my screenshot, this is "State and County Tax."

3) The Parent Tax Account Type must specifally be "CTAX" unless you change the [COMBINED_TAX_CODE variable](https://github.com/jboeke/com.avietech.multitax/blob/master/multitax.php#L11) in the code.

4) Use the Parent Tax Description to create a comma separated list of the Accounting Codes you wish to be the Child Taxes for this Parent. (NOTE: NO spaces.)


## Notes

All Accounting Codes for taxes must be unique for this extension to work.

This is only designed and tested for Events at the moment.

Upon saving an event, the _pre hook will break down the tax and store it as multiple lines in the civicrm_financial_item table.
