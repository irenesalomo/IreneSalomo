=== TinyMCE Signature ===
Contributors: keighl
Donate link: http://www.keighl.com/plugins/tinymce-signature/
Tags: signature, author, rich edit, tiny mce
Requires at least: 2.8
Tested up to: 3.0
Stable tag: trunk

Automatically adds a signature to your posts. Configurable via TinyMCE on the profile page.

== Description ==

Automatically adds a signature to your posts. Configurable via TinyMCE on the profile page.

= Use =

1. Edit your signature from Users -> Your Profile
1. Choose to display the signature by default on posts or pages.
1. Override signature on specific posts/pages via the edit page. 

= Support = 

For any issues you're having with TinyMCE Signature, or if you'd like to suggest a feature, visit the [Plugin Homepage](http://wwwkeighl.com/plugins/tinymce-signature/ "Plugin homepage").

== Installation ==

1. Upload `tinymce-signature.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Create a signature via Users -> Your Profile
1. Optional: add template tag, `tinymce_signature()' to theme (must be in The Loop)

== Frequently Asked Questions ==

= Can the signature option be overridden on the post/page editing screen?  =

Yep.

= How is the signature included in my posts? =

TinyMCE Signature will append your signature automatically to all your posts; no theme alterations needed.

You may also use the template tag `tinymce_signature()` in The Loop to return the signature. 

= Will the signature appear on an archive page? =

No. If you want to do this, use the template tag, `tinymce_signature()` within The Loop.

== Screenshots ==

1. A view from the profile interface.

== Changelog ==

= 0.6 = 
* Made signature return for archive pages optional. 


= 0.5 = 
* Included the kitchen sink. 
* Toggle button to switch between html and visual modes ... for those wanting more control over the markup.
* Removed automatic signature insertion from archive pages. 

= 0.4 =
* Fixed some bugs with the post appending script
* Add a wicked simple template tag that returns the signature regardless of display options. 

= 0.3 =
* Fixed some overriding bugs
* Choose default signatures for posts and pages separately.

= 0.2 =
* Added override option for each post (on the edit page).

= 0.1 =
* Initial release.



