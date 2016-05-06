Pimcore Sitemap Plugin
======================
XML sitemap generator for Pimcore. Built from the document tree.

## Installation
1. Run the command ```composer require byng/pimcore-sitemap-plugin```
2. Enable the plugin from Extras => Extensions on Pimcore admin panel 

## Pimcore Sitemap Plugin Settings 
1. Set the name of the domain at imcore system settings below the Website tab
2. Set up environment to Production at Pimcore System Settings below the Debug tab
3. Create new predefined property. Then add this property to every page that you want to exclude from the sitemap 
    * name => Sitemap: Exclude page
    * key => sitemap_exclude
    * type => bool  
    * value => true
    * inheritable => yes
    
## License

MIT