=== Quatriceps ===
Contributors: pmagunia
Tags: math,education,shortcode,arithmetic,learning
Requires at least: 3.9.2
Tested up to: 4.5.2
License: GPLv2  or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Generate solutions to common math problems.

== Description ==

Contributor's Note: this project has been abandoned and is no longer supported. 

Quatriceps is a free mathematics API for generating solutions to basic arithmetic problems. This plugin allows easy setup of Quatricep blocks on a Wordpress blog for student use.

When a student submits a problem, a formatted solution is retrieved from a remote server. Quatriceps operations and output will emphasize instructional solutions. Tetragy welcomes requests for new operations that may be specific to a user or organization.

See the Tetragy Quatriceps API page for all currently supported operations. A demo is available at https://wp.tetragy.com/quatriceps.

== Installation ==

1. Download and extract the Simple-MathJax and Quatriceps zip file to your `/wp-content/plugins/` directory.
2. Enable the Simple-MathJax and Quatriceps plugins
3. Use Shortcode in your posts to include a Quatriceps operation. For example: `[quatriceps com="addition"]`.

== Frequently Asked Questions ==

= How much does it cost ? =

All computation requests with optional PDF output are free.

= Do I need to install anything else on my server ? =

No, Wordpress and the Quatriceps plugin are the only software requirements. By default, requests are sent the public Tetragy Quatriceps backend server. You can visit https://github.com/pmagunia/tserver use your own backend server with custom operations.

= Where can I try a demo ? =

http://wp.tetragy.com/quatriceps


References

- http://www.latex-project.org
- http://www.ctan.org/pkg/xlop
- http://www.google.com/recaptcha
- https://math.tetragy.com

== Screenshots ==

1. Addition operation
2. Subtraction operation
3. Multiplication operation
4. Division operation
5. PDF output
6. Quatriceps UI
7. Quatriceps Shortcode syntax for including operation on a page or post

== Changelog ==

= 1.1.3 =
* Allow multiple simultaneous requests per page
* Remove obsolete code
* New operations
* Remove recaptcha code


= 1.1.2 =
* CSS fix for recaptcha table
* Change wording of settings page

= 1.1.1 =
* Drop support for MathJax-LaTeX in favor of Simple-MathJax

= 1.1.0 =
* New operations: lcm, addfrac, divfrac, equivfrac, factors, gcf, multfrac, num2words, simplfrac, subtrac
* New features: LaTeX support

= 1.0.0 =
* Override packaged CSS and JS files

= 0.1.1 =
* Cosmetics

= 0.1.0 =
* Initial commit

== Upgrade Notice ==

= 1.1.3 =
No security updates, Minor bug fixes, new features, deprecated Recaptcha code

= 1.1.2 =
No security updates, Minor bug fixes

= 1.1.0 =
New operations, LaTeX support

= 1.0.0 =
Allows overriding CSS and JS files. No bug fixes or cosmetic changes.

= 0.1.1 =
No bug fixes, No new features, minor cosmetic changes
