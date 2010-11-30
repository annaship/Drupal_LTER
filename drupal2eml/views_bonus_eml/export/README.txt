Bonus: Views Export EML
--------------------------------------------------------------------------------
This modules is based on Bonus: Views Export and adds EML feed type
that can be used to export data from your views.

You can use default view with path as "eml_view/NODE_ID" or change it:
--------------------------------------------------------------------------------
1. Add a new "Feed" display to your view.
2. Change its "Style" to the "EML file".
3. Configure the options (such as name, quote, etc.). You can go back and do
   this at any time by clicking the gear icon next to the style plugin you just
   selected.
4. Give it a path in the Feed settings such as "path/to/view/eml".
5. Optionally, you can choose to attach this to another of your displays by
   updating the "Attach to:" option in feed settings.

-------------------------------------------------------------------------------

views-bonus-eml-export-eml.tpl.php
1. creates a template
2. populates data into the template

views-bonus-eml-export-eml-vars.tpl.php
1. takes all the dataset related data from db in an Array
2. calculates vid version

views-bonus-eml-export-eml-funcions.tpl.php     
functions, used in previous two files, goes here
