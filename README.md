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


---

# Features

## Fill in the content as HTML or MD
## Insert shortcodes like [[youtube id="7c238trc"]] into the content (HTML or MD)

--

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