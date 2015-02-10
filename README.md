# Joomla-Periodicals-Component
Easily manage periodicals in pdf format.

This component allows you to upload pdf files and list the files easily on your website. 
When you upload a pdf file, you will have to enter the year, month and day the periodical was released. On your site, these items will be listed newest first. You can choose not to use the year, the month or the day, if your periodicals don't come out that often or you can choose multiple months or days if your periodical stretches over more than one of those.

The listed articles will behave just like an article, making it fit in with most Joomla templates.

##Options:
* <b>Use year</b>: If you enable this option, assigning a year to your periodical is required
* <b>Use month</b>: If you enable this option, assigning a month to your periodical is required
* <b>Use day</b>: If you enable this option, assigning a day to your periodical is required
* <b>Default folder</b>: Allows you to select a sub folder from your site's media directory where the pdf files will be uploaded to
* <b>Obscure titles</b>: If this option is enabled, a string of random characters will be added to the file name, making it harder for people to guess the name of the files. This option can be useful if your periodicals aren't available for everyone.
* <b>Maximum file size</b>: Allows you to set the maximum allowed file size for your uploads. This will not override your server settings, but you can use this to make sure pdf files aren't too large

##Menu options:
* <b>Body prefix</b>: Allows you to add an introductory text to the listed files. This text will appear directly below the title, but above the listed files
* <b>Use titles</b>: Seperates the periodicals into groups, with a title containing the year (if months are enabled) and the months (if days are enabled) above the group
* <b>Prefix</b>: The text that will be added to the beginning of each periodical listed
* <b>Suffix</b>: The text that will be appended to each periodical listed
* <b>Fill</b>: If enabled, missing periodicals will appear in the list as well, but without links to the file
* <b>Use month names</b>: If enabled, names will be written in natural languages instead of appear as a number
* <b>Capitalize month names</b>: If enabled and month names are used, month names will be capitalized

##Access Control List (ACL)
* Administrator interface acces
* Allow change settings
* Allow add
* Allow edit
* Allow edit own
* Allow edit state (publish or unpublish)

