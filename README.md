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

## Copy Google Table (Sheet) to your drive 
https://docs.google.com/spreadsheets/d/19NC3QrrWEvAwljyhzKF9LqCds4gtOvP5OAZUqqd3k-w/edit?usp=sharing 

## Migration tables to your database 
```
php bin/console doctrine:migrations:migrate 
```
It is migrate file migrations/Version[id].php to your database! 

## Change Key and Domain in Google Table
![alt text](.docs/readme/image.png)
![alt text](.docs/readme/image-1.png)
> Внимание! Если у вас на сайте ещё нет https то необходимо в ссылке заменить https на http! 

## And set this key to .env file 
![alt text](.docs/readme/image-2.png) 

## Compress code to ZIP and upload to server (for example to shared hosting) 
![alt text](.docs/readme/image-3.png) 
![alt text](.docs/readme/image-4.png) 
![alt text](.docs/readme/image-5.png) 

## Setting HTTPS and redirect to it and setting last PHP version at you site in hosting panel or you server! 

## Update composer vendors (libs) 
For example at shared hosting (beget.com): 
```
php8.3 $(which ~/.local/bin/composer) update
```
![alt text](.docs/readme/image-6.png) 

## Then create first page at google table! 
![alt text](.docs/readme/image-7.png)

## And upload this content to site! 
1. Select the line (web page data) that you want to send to the site. 
2-3. Send the changes to the website! 
![alt text](.docs/readme/image-8.png) 

After that, the cache of this page will be reset and the updated content will be displayed on the site!

In this case, the content can be written directly to the content column, so you can place a link to html or md markup there so as not to clutter the table cell!



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