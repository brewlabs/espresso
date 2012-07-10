=== ThemeKit For WordPress ===
Contributors: joshl, jaredharbour
Tags: options, settings, management
Requires at least: 3.0
Tested up to: 3.1
Stable tag: 0.5.3

Supercharge your WordPress themes and plugins with powerful features that are easy to create.

== Description ==

[ThemeKit](http://themekitwp.com/) is a WordPress plugin that helps you supercharge your self-hosted WordPress themes and plugins by providing a uniform way to create options.

For more information, check out [themekitwp.com](http://themekitwp.com/).

Features include:

* Integration with Google Fonts.
* All data is save in a single option and images are using a custom post type. 
* Easily create options for almost anything.
* Prebuilt controls for fonts, borders, text, checkboxes, radio buttons and more.
* Customized version of the WordPress Media Uploader for image management.
* and *many* more options to come!

== Installation ==

1. Install ThemeKit either via the WordPress.org plugin directory, or by uploading the files to your server
2. After activating ThemeKit you will only notice that is is their if a plugin or theme requires it.
3. That's it.  You're ready to go!
4. Enjoy your awesome new options.


== Frequently Asked Questions ==

= I am not a developer or designer, why would I need ThemeKit? =

If a plugin or theme developer used ThemeKit to power the settings they created you will need to install ThemeKit. Although once installed and active you will not need to do anything else. ThemeKit is a framework for creating options/settings pages and designed to run in the background.

== Screenshots ==

1. Settings screen style option one
2. Settings screen style option two
3. This is most of the form elements currently in ThemeKit.
4. Custom "insert into option" button used when uploading images.
5. Quick code sample showing basics of creating an options page.  

== Changelog ==

= 0.5.3 =
* Started better function documentation
* Changed references to $this->_option_name to use get_option_name function. 
* Changed references to $this->_menu_title to use get_menu_title function. 

= 0.5.2 =
* Added support for CSS preview on options page
* Added support for no background color. Options save as # sets css to background: none;
* added new option type styleonly.

= 0.5.1 =
* Added option to set where the themekit menu gets added (defaults to Appearance)
* Added description controller that prints the text thats passed to it to the page.
* Added public function get_version() that returns the current plugin version.

= 0.5 =
* Initial release
