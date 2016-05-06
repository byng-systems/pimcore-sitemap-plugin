# pimcore-sitemap-plugin
XML sitemap generator for Pimcore. Built from the document tree.

# Pimcore Sitemap Plugin Settings 
1. Set the name of the domain at pimcore system settings below the Website tab
2. Set up enviroment to Production at pimcore System Settings below the Debug tab
3. Create new predefined property. Then add this property to every page that you want to exclude from the sitemap 
    * name => Sitemap: Exclude page
    * key => sitemap_exclude
    * type => bool  
    * value => true
    * inheritable => yes
    

