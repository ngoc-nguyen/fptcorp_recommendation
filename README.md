# FPT Recommendation Module

Thank you for trying the FPT Recommendation module! 
This module will improve your sales significantly. More deals are facilated when visitor are served with relevant offers and additional cross-and-upsell recommendations.

## Installing and verifying the reference module

You can install the reference module in any of the following ways:

1. By copying the code to your `<your Magento install dir>/app/code/<VendorName>/<ModuleName>` directory.  
   This method requires some manual tasks but it easy.
2. Using `composer require`.


### Installing the module by copying code

Any Magento module requires a particular directory structure under `<your Magento install dir>/app/code`. The structure starts with:


	<VendorName>/<ModuleName>

The reference module requires the following structure:

	FPTCorp/Recommendation

To add the module to your Magento installation:

1. Log in to your Magento server as a user with privileges to write to the web server docroot (typically either the `root` user or the web server user).
2. Enter the following commands in the order shown:

		cd <your Magento install dir>/app/code
		mkdir -p FPTCorp/Recommendation

3. Go to the [reference module GitHub](https://github.com/ngoc-nguyen/fptcorp_recommendation).
4. Click **Download Zip**.
5. Copy the `.zip` file you downloaded to your Magento server's `<magento install dir>/app/code/FPTCorp/Recommendation` directory.
6. Enter the following commands in the order shown:

		unzip fptcorp_recommendation-master.zip
		mv fptcorp_recommendation-master/* .
		rm -rf fptcorp_recommendation-master
		rm -f fptcorp_recommendation-master.zip

6.	Open `<your Magento install dir>/app/etc/config.php` in a text editor.
7.	Add the following anywhere under: `'modules' => array (`:

		'FPTCorp_Recommendation' => 1

8.	Save your changes and exit the text editor.

### Installing the module using Composer

Enter the following command in the order show 

		cd <your Magento install dir>
		composer require fptcorp/recommendation
		bin/magento setup:upgrade
		bin/magento cache:flush

### Verifying the reference module

1. Log in to your Magento server as a user with `root` privileges.
2. Enter the following commands in the order shown to clear the Magento cache:

		cd <your Magento install dir>/var
		rm -rf cache page_cache


3. If you're currently logged in to the Magento Admin, log out.
4. Log in to the Magento Admin as an administrator.
5. Click **Stores** > **Configuration** 

If **FPTCORP** tab displays you successfully installed the reference module!

To use the module you should register with us https://dashboard.knowlead.io/signup 
After signup an email will be sent to you with siteId and API_key to enable the module.
Go to the FPTCorp tab, enter the siteId and API_key as in the email. Save the config.

From the command line enter the following in the order show 

		cd <your Magento install dir>
		bin/magento cache:flush

To see the reference module at work.

After visitor use the system for a while a list of recommended products displays. That's it! You're done!