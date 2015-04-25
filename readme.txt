=== MemberMouse Member Count ===
Contributors: wpdevco, jasonmanheim
Tags: shortcodes, membermouse, membership, members
Requires at least: 4.0
Tested up to: 4.2
Stable tag: 1.2.0
License: GPL v3
License URI: http://www.gnu.org/licenses/

Display the total count of active members in MemberMouse (with optional Membership Level and Bundle attributes) via shortcode.

== Description ==
Display the total count of active members in MemberMouse (with optional Membership Level and Bundle attributes) via shortcode. Output is cached for 24 hours. 

= Examples =
* **Total active members:** [mm-active-member-count]
* **Active members with *Membership Level* 1:** [mm-active-member-count level="1"]
* **Active members with *Bundle* 3:** [mm-active-member-count bundle=“3”]
* **Active members with *Membership Level* 1 and *Bundle* 3:** [mm-active-member-count level=“1” bundle=“3”]

> This plugin is an add-on and requires [MemberMouse](http://membermouse.com/).

== Installation ==
1. Upload the plugin to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Use the [mm-active-member-count] shortcode in any content area.

== Frequently Asked Questions ==
= How do I find Membership Level IDs? =

Hover over the name of any level in MemberMouse -> Product Settings -> Membership Levels

= How do I find Bundle IDs? =

Hover over the name of any bundle in MemberMouse -> Product Settings -> Bundles

= Can I style the output? =

Absolutely. The output is wrapped in a `<span>` with the class `mm-active-member-count`, `mm-level-x`, and `mm-bundle-x`.

== Screenshots ==
1. Multiple shortcodes on a page.
2. Shortcodes output.

== Changelog ==
= 1.2.0 - April 25, 2015 =

* Add support for Bundles using an optional `bundle` attribute.

= 1.1.0 - March 16, 2015 =

* Fix dependency check for MemberMouse with `plugins_loaded` hook.

= 1.0.1 - March 15, 2015 =

* Update readme.

= 1.0.0 - March 14, 2015 =

* Initial release.

== Upgrade Notice ==
= 1.2.0 =

Add support for Bundles.