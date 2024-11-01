=== Temporarily Hidden Content ===
Contributors: codents, alejandrodiegoo
Donate link: https://codents.net
Tags: seo, gutenberg, blocks, content, entries, pages, schedule
Requires at least: 3.0.1
Tested up to: 6.0.1
Stable tag: trunk
Requires PHP: 5.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Hide or show content until specific date.

== Description ==

Temporarily Hidden Content is a plugin that allows you to show or hide content until a specific date. You can add or remove content from your pages and entries without edit again. In addition, you can notify your users with a countdown of when the content will be available. 

== Installation ==

1. Install Temporarily Hidden Content either via the WordPress.org plugin repository or by uploading the files to your server.
2. Activate Temporarily Hidden Content.
3. Edit your pages and entries to include the shortcodes **[temphc-start]** o **[temphc-end]**.

== Frequently Asked Questions ==

= How do I hide content? =

To hide temporarily a content you must use the shortcode **[temphc-start]** with the mandatory attributes **'on'** and **'at'**. This content will be hidden until the indicated date.

`
[temphc-start on="2020-08-21" at="15:30"]
`

Then you must include the content you want to hide temporarily and close the shortcode.

`
[/temphc-start]
`

This shorcode has 3 optional attributes, **'countdown'** to show the user the remaining time, **'color'** to change the main color of the counter and **'message'** to change the default message that appears below the countdown.

`
[temphc-start on="2020-08-21" at="15:30" countdown="true" color="orange" message="this content is temporarily hidden"]
`

= How do I show content? =

To show temporarily a content you must use the shortcode **[temphc-end]** with the mandatory attributes **'on'** and **'at'**. This content will be available until the indicated date.

`
[temphc-end on="2020-08-21" at="15:30"]
`

Then you must include the content you want to show temporarily and close the shortcode.

`
[/temphc-end]
`

= Who should use Temporarily Hidden Content? =

Temporarily Hidden Content is perfect for business owners, bloggers, designers, developers, photographers, and basically everyone else. It can also be a useful tool for SEO. you can hide certain content so that they appear little by little and Google and others search engines detect new content on your page with each visit.

= What colors are available? =

Currently through the color tag you can select the following colors: Black, red, blue, orange, green and pink. However, if you want another color, it's always possible to overwrite the CSS style sheets.

== Screenshots ==

1. Using the shortcode.
2. Countdown view.
3. Countdown has ended.
4. Content is unlocked.

== Upgrade Notice ==

== Changelog ==

= 1.0.6 =
* Added compatibility with Wordpress 6.0.1.

= 1.0.5 =
* Added compatibility with Wordpress 5.9.

= 1.0.4 =
* Fixed bug with version 8 of PHP.

= 1.0.3 =
* Added compatibility with Wordpress 5.7.2.

= 1.0.2 =
* Added compatibility to show and hide another shortcodes.

= 1.0.1 =
* Fixed class reference error.

= 1.0.0 =
* Initial release.

[See changelog for all versions](https://plugins.svn.wordpress.org/temporarily-hidden-content/trunk/changelog.txt).
