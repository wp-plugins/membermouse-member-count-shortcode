=== MemberMouse Member Count ===
Contributors: wpdevco, jasonmanheim
Tags: shortcodes, membermouse, membership, members
Requires at least: 4.0
Tested up to: 4.1.1
Stable tag: 1.0.1
License: GPL v3
License URI: http://www.gnu.org/licenses/

Display the total count of active members in MemberMouse (with optional Membership Level attribute) via shortcode.

== Description ==
Display the total count of active members in MemberMouse (with optional Membership Level attribute) via shortcode. Output is cached for 24 hours. 

=== Examples === 
* **Total active members:** [mm-active-member-count]
* **Active members with *Membership Level* 1:** [mm-active-member-count level="1"]

> This plugin is an add-on and requires [MemberMouse](http://membermouse.com/).

== Installation ==
1. Upload the plugin to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Use the [mm-active-member-count] shortcode in any content area.

== Frequently Asked Questions ==
= How do I find my Membership Level IDs? =

Hover over the name of any level in MemberMouse -> Product Settings -> Membership Levels

= Can I style the output? =

Absolutely. The output is wrapped in a `<span>` with the class `mm-active-member-count` and `mm-level-x`.

= Can I display total members with 'x' bundle? =

Not at this time.

== Screenshots ==
1. Multiple shortcodes on a page.
2. Shortcodes output.

== Changelog ==
= 1.0.1 - March 15, 2015 =

* Update readme.

= 1.0.0 - March 14, 2015 =

* Initial release.

== Upgrade Notice ==
= 1.0.0 =

Initial release.