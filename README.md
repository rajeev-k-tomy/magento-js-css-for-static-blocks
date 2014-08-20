Rkt_JsCssforSb
================================

INTRODUCTION
------------
A Magento Extension that will allow to add javascript and css for static blocks. This extension makes static blocks somewhat "dynamic". For every static block, there will be provision to add javascript and CSS to that particular static block. Whenever static blocks with js and css are rendered in frontend, these properties will get applied  to that static blocks

COMPATIBILITY
---------------

Currently this extension supports Magento 1.8


THEORY
--------

For more theoretical details of extension, you can checkout my blog

ADVANCED DETAILS
------------------

This extension has
<pre>
Rewrite - 1
Observers - 3
</pre>

SNAPSHOTS
----------
http://stackoverflow.com/questions/17832914/how-do-i-extend-cms-block-on-save-event-of-magento

NOTES
------

1. Don't put `<script>` or `<style>` tags inside the text areas. The extension will autogenerate this enclosure html tags.
2. You can put javascirpt and css directly inside text areas
3. Don't put html contents inside the text area
4. You can put jquery in text area. In this case, it is your job to make sure that, necessary jquery files are added.
5. By default, all the script that are related to static blocks are get included in the bottom side of the page and css files are included in `head` part (bottom side).

