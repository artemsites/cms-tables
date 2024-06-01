# CMS Sheets - a site management system based on Symfony and Google Tables

---

# Installation 

## Clone cms-sheets: 
```
git clone git@github.com:artemsites/cms-sheets.git
```

## Copy and rename 
```
.env.example -> .env
```

## Set connection MySQL in .env 
```
DATABASE_URL="mysql://username:password@server.com:3306/dbname"
```
With mysql version:
```
DATABASE_URL="mysql://username:password@server.com:3306/dbname?serverVersion=5.7.21"
```

## Update vendor libs 
```
composer update
```



## Install Symfony at local pc for development
https://symfony.com/doc/current/setup.html



## Create site files in Google Drive: 
1 Create site folder for site files in Google Drive
  somesite.com
2 Download file "Pages & Menu"
  https://docs.google.com/spreadsheets/d/17Z1l-7S-VNsdHu3RWHbEIOrtjSi37D-1aOKoK_moX7g
3 Create in Google Drive: 
  somesite.com/Pages & Menu



## Upload code to your server 
One level higher than your public folder for the site! 

## Create link to public 
If the root folder on your server is set to public_html:  
```
ln -s public public_html
```
---

# Features 

## Fill in the content as HTML or MD 
## Insert shortcodes like [[youtube id="7c238trc"]] into the content (HTML or MD) 

---

# Configuration 

## Vue the type of interpolation brackets is specified in .env: 
  SHORTCODE_START_REGEXP   
  SHORTCODE_END_REGEXP    
  > It shouldn't be {{ }} - it's twig   
  > It shouldn't be [ ] - this is md content   
  > Probably better [[ ]]   
  > ! It is important to specify in REGEXP format, that is, special characters should be escaped \[\[ - otherwise they will be incorrectly read in REGEXP and will not be used   

---

# Shortcodes

Double brackets are selected as in MODx: [[shortcodename]],   
because there is a conflict with md parsing   
(there links look like [name](http://...))   

## [[youtube id="7c238trc"]] - YouTube video output
  Parameters:    
    id is the ID of a YouTube video    

## [[code code="some code"]] - code block output
  Parameters:   
    code - if this is a link, then we will get the content that is located on the link    

## [[articles]] - output of all child articles for this url in the form of links