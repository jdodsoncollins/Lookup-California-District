# Lookup California District

Lookup Caiifornia District is intially based on the codebase of [Find Your Reps](https://wordpress.org/plugins/find-your-reps/), though with substantial-enough modifications to where it is essentially a differnent plugin now. 

The purpose of this plugin was to provide an attractive form interface for [adems2017.vote](adems2017.vote) to display local representatives based on the vistor's address. Other available options were deemed too complex, unavailable, or not fitting the look we wanted. It uses the [Google Maps Javascript API](https://developers.google.com/maps/documentation/javascript/) as well as the [Open States API](https://openstates.github.io/openstates-api/).

I'm uploading this as a quick functional demo for those seeking a similar task. The code itself is very **very** basic -- simple PHP and jQuery network calls to work with a vanilla WordPress install with a Boostrap 3+ theme -- nothing I would deploy in a long-term project. The goal here was to get this up and running ASAP, in just a few hours (including research).


## Usage

Because this plugin is intended for internal use and has a narrow focus, I didn't make it very configurable. 

#### __Flow:__
1. User sees form with two fields: street address and city (zip is not needed, state assumed to be CA)
2. User enters valid address, triggers submit
3. Address is sent to Google Maps API, results are returned. An error is shown if there are no results.
4. If address is valid, POST to the open states API to retrieve a response of local representatives.
5. Using the response from open states, get the district #. 
6. Make AJAX request to see if URL /ad** exists where ** is the district number returned. Redirect there if it exists.

Notes:

* Your WordPress pages should respect these URLs and load the appropriate information when hit.
* Appropriate error messages are shown in the DOM or via alerts if anything fails to load or is not present in the above steps.

## Installation 

The plugin requires an activation key from the Sunlight Foundation in its settings in the WP admin panel. As of Jan 2017, this key is any email and a traditional API key is not required.

### Manual Installation 

1. After downloading the plugin, unzip the plugin.
2. Add Google Maps API key to line 24 of `find-your-reps.php` where you see `$googleMapsKey`
2. Upload the `find-your-reps` directory into your `wp-content/plugins` directory so that the structure is `wp-content/plugins/find-your-reps/....`
3. Activate the plugin in your WordPress admin.

### Better Installation 

1. Add Google Maps API key to line 24 of `find-your-reps.php` where you see `$googleMapsKey`
2. Go to Plugins > Add New in your WordPress admin and search for 'Find Your Reps'.
3. Click Install.
4. Click Activate.

### Configuration 

1. Configure the plugin via the Find Your Reps link that appears in the Settings Menu section of the left sidebar in the backend.
2. To change the default styling copy fyr.css from plugins/find-your-reps/css to your theme directory.

## Room for future improvement (the todos)
* move Google maps API key into settings 
* Use Javacript promises rather than callbacks
* refactor Javascript
* add options for URL scheme rather than /ad** default


