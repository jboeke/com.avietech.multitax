# com.avietech.multitax

WORK IN PROGRESS - NOT SUITABLE FOR ANYTHING BUT CAUSING ERRORS!

A CiviCRM Extension for the purpose of storing taxes in individual components. 

In the case where you might have a city and state tax, you'll need to report on both.

Constants in multitax_constants.php will define the parent account and the individual components of that tax.

Upon saving a contribution, the pre hook will break down the tax and store it as multiple lines in the civicrm_financial_item table.

That's the plan, for now.