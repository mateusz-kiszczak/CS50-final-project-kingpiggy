# Kingpiggy - CS50's Final Project

## Video Demo: [Kingpiggy Video Demo](https://youtu.be/U5UND_XCUCk)

## Live Demo: [Kingpiggy Video Demo](https://kingpiggy.com/)

## Description

Kingpiggy is a website that shares royalty images with the rest of the world. Anyone can contribute to the website by registering an account and uploading pictures. Those pictures are later verified, and if they do not have any "unwanted" content, they become visible to the public.

The website was designed based on other popular websites with the same functionality to preserve the UI familiar to users and add some new details that make it unique.

The UI/UX was designed in Figma. To see the graphic project, please follow the link below.

[Kingpiggy design in Figma](https://www.figma.com/design/ClpPoIftCBDIGUdrxOaF5K/kingpiggy?node-id=27-226&m=dev&t=Y9w2qKKpHfp14JPz-1)

Kingpiggy web aplication was created using the fallowing programing languages, frameworks and techniques:

* HTML
* CSS (SASS)
* JavaScript
* jQuery
* AJAX
* PHP
* SQL (MySQL)

Software used to create the webside

* Figma
* Photoshop
* Illustrator
* Visual Studio Code
* XAMPP
* PHPmyadmin

---

## Files Structure

root/  
| - - /ajax/  
| - - | - - index-load-images.php  
| - - | - - search-next-page.php  
| - - /images/  
| - - | - - /avatars/  
| - - | - - /images/  
| - - | - - /temp/  
| - - | - - /thumbnails/  
| - - /private/  
| - - | - - /config/  
| - - | - - | - - config.php  
| - - | - - /core/  
| - - | - - | - - init.php  
| - - | - - /dashboard/  
| - - | - - | - - admin.php  
| - - | - - /filters/  
| - - | - - /helpers/  
| - - | - - | - - absolute-url.php  
| - - | - - | - - client-ip.php  
| - - | - - | - - date.php  
| - - | - - | - - error_class.php  
| - - | - - | - - filter.php  
| - - | - - | - - flash.php  
| - - | - - | - - helpers.php  
| - - | - - | - - image.php  
| - - | - - | - - is_get_post.php  
| - - | - - | - - login.php  
| - - | - - | - - redirect.php  
| - - | - - | - - sanitize.php  
| - - | - - | - - session.php  
| - - | - - | - - sql.php  
| - - | - - | - - string.php  
| - - | - - | - - validate.php  
| - - | - - | - - view.php  
| - - | - - /libraries/  
| - - | - - | - - Comment.php  
| - - | - - | - - Database.php  
| - - | - - | - - Img.php  
| - - | - - | - - PrivateUser.php  
| - - | - - | - - Profiles.php  
| - - | - - | - - PublicUsers.php  
| - - | - - | - - SearchSearch.php  
| - - | - - | - - Template.php  
| - - /temp/  
| - - /templates/  
| - - | - - /includes/  
| - - | - - | - - footer.php  
| - - | - - | - - go_up_button.php  
| - - | - - | - - header_home.php  
| - - | - - | - - header.php  
| - - | - - | - - image_element.php  
| - - | - - /js/  
| - - | - - | - - script.js  
| - - | - - /src/  
| - - | - - | - - /avatar/  
| - - | - - | - - /icons/  
| - - | - - | - - /production-img/  
| - - | - - /style/  
| - - | - - | - - /sass/  
| - - | - - | - - | - - /abstract/  
| - - | - - | - - | - - | - - _colors.scss  
| - - | - - | - - | - - | - - _index.scss  
| - - | - - | - - | - - | - - _mixins.scss  
| - - | - - | - - | - - /base/  
| - - | - - | - - | - - | - - _global.scss  
| - - | - - | - - | - - | - - _index.scss  
| - - | - - | - - | - - | - - _media-queries.scss  
| - - | - - | - - | - - | - - _reset.scss  
| - - | - - | - - | - - /components/  
| - - | - - | - - | - - | - - _alert.scss  
| - - | - - | - - | - - | - - _buttons.scss  
| - - | - - | - - | - - | - - _divider.scss  
| - - | - - | - - | - - | - - _form.scss  
| - - | - - | - - | - - | - - _index.scss  
| - - | - - | - - | - - | - - _pictures.scss  
| - - | - - | - - | - - | - - _search_bar.scss  
| - - | - - | - - | - - | - - _sort.scss  
| - - | - - | - - | - - | - - _tags-slider.scss  
| - - | - - | - - | - - | - - _zoom-image.scss  
| - - | - - | - - | - - /layout/  
| - - | - - | - - | - - | - - _footer.scss  
| - - | - - | - - | - - | - - _header.scss  
| - - | - - | - - | - - | - - _index.scss  
| - - | - - | - - | - - | - - _navigation.scss  
| - - | - - | - - | - - /pages/  
| - - | - - | - - | - - | - - _home.scss  
| - - | - - | - - | - - | - - _image.scss  
| - - | - - | - - | - - | - - _index.scss  
| - - | - - | - - | - - | - - _legal.scss  
| - - | - - | - - | - - | - - _list.scss  
| - - | - - | - - | - - | - - _register-login.scss  
| - - | - - | - - | - - | - - _search.scss  
| - - | - - | - - | - - | - - _user-dashboard.scss  
| - - | - - | - - | - - | - - _user.scss  
| - - | - - | - - | - - /thames/  
| - - | - - | - - | - - /utilities/  
| - - | - - | - - | - - | - - _container.scss  
| - - | - - | - - | - - | - - _helpers.scss  
| - - | - - | - - | - - | - - _index.scss  
| - - | - - | - - | - - /vendors/  
| - - | - - | - - | - - style.scss  
| - - | - - | - - style.css  
| - - | - - /user_dashboard/  
| - - | - - | - - /includes/  
| - - | - - | - - | - - user-dashboard-footer.php  
| - - | - - | - - | - - user-dashboard-header.php  
| - - | - - | - - delete-account.php  
| - - | - - | - - downloads.php  
| - - | - - | - - edit-profile.php  
| - - | - - | - - favourites.php  
| - - | - - | - - my-images.php  
| - - | - - | - - notifications.php  
| - - | - - | - - upload-image.php  
| - - /user_dashboard/  
| - - | - - /submit/  
| - - | - - | - - delete-image.php  
| - - | - - | - - update_preferences.php  
| - - | - - | - - update-password.php  
| - - | - - | - - update-profiles.php  
| - - | - - | - - upload-avatar.php  
| - - | - - delete-account.php  
| - - | - - downloads.php  
| - - | - - edit-profile.php  
| - - | - - favourites.php  
| - - | - - my-images.php  
| - - | - - notifications.php  
| - - | - - upload-image.php  
| - - about-us.php  
| - - cookies-policy.php  
| - - faq.php  
| - - image.php  
| - - index.php  
| - - license.php  
| - - list.php  
| - - login.php  
| - - logout.php  
| - - privacy-policy.php  
| - - register.php  
| - - search.php  
| - - terms-and-conditions.php  
| - - user-dashboard.php  
| - - users.php  

---

## Folders and Files
  
### ajax directory

In the Ajax folder, we have two files that were used to manage the jQuery AJAX asynchronous updates to the database.

#### ajax/index-load-images.php

By default, the home page loads only 20 pictures.
At the bottom of the section with the pictures, we have a 'Load More' button. When we press it, the page loads another 20 images using jQuery AJAX.
We can load up to 80 images. After that, the button changes to 'Show All' and redirects us to another page with all the images available on the website.

#### ajax/search-next-page.php

This file changes the result page manually by entering the number of the page we want to jump in. It is a simple form handle file.
It was created in a separate file to unload the amount of the code from the search.php file, which was already handling other forms.

### images directory

The image directory holds all the uploaded images, image thumbnails (rescaled images for the faster loading process) and user avatars.

### private directory

It includes all the functions, DB connections, and classes required for the website to run correctly.
This folder should not be available to public users.

#### /private/config/config.php

In the config.php file, I defined a global variable with values necessary for connecting with a database.

#### /private/core/init.php

The init file loads the config.php using require_once (a PHP function) and handles the autoloaded for Classes.

#### /private/dashboard/admin.php

An admin dashboard which helps in managing the database by verifying images uploaded by users, etc.
It comes in a more appealing UI than PHPMyAdmin.

#### /private/filters

This folder holds some JavaScript files with arrays of profane words and phrases, respectively.
It's a hard copy of a collection of words that are banned across the website whenever the user can use a string input.
The same collections are in the database.

#### /private/helpers/absolute-url.php

A functions that return an absolute URL address.

#### /private/helpers/client-ip.php

A function that return user's current IP address.

#### /private/helpers/date.php

Date.php contains functions related to formating dates.
It converts timestamp data from the database to string and reverses.

#### /private/helpers/error_class.php

This file have a function that returns a string with a class name used for form inputs errors.

#### /private/helpers/filter.php

Filter.php combines sanitize and validate functions into one.
It returns an associate array with user inputs and error messages.
Used for handling the forms after submitting.

#### /private/helpers/flash.php

In this file, we can find a set of functions related to the flash message.
A flash message is a message that will appear on the screen, for example, after the successful form submission.
When displayed, it creates a session with a unique ID so the message can be visible after the redirecting.

#### /private/helpers/helpers.php

This file includes all the files from the helper's directory. It's used for easier reference in other php files.

#### /private/helpers/image.php

In this file, we have a function that reduces the size and quality of the uploaded images.
It's used to manage the image's thumbnails and to reduce the size of users' avatars.
It also contains a few functions that calculate the image properties, like image ratio, width, height, and orientation.

#### /private/helpers/is_get_post.php

Here, we have two functions that simply check whether the request method was GET or POST.

#### /private/helpers/login.php

A set of login and logout functions.
It is used to validate if the user's password matches the encrypted password from the database and set up sessions to remember logged-in users.
A logout function destroys sessions and redirects users to the login page. Other functions check if a user is logged in.

#### /private/helpers/redirect.php

The redirect file contains three functions.
First, redirect to another page.
Second, redirect and create a session with an associate array as a value.
Third, redirect and create a flash message.

#### /private/helpers/sanitize.php

This file contains functions used to sanitize user input while submitting forms.

#### /private/helpers/validate.php

This file contains functions used to validate user input while submitting forms.

#### /private/helpers/view.php

The view is a helper function that manages the pages' titles.
  
### /private/libraries/ directory

The libraries directory contains files of classes created to manage SQL connections.
Every class has a set of methods to perform CRUD actions. Database.php is the main class that creates the connection with the database; it also contains methods for easier reference when validating inputs with PHP PDO.

### templates directory

In the templates directory, we have website pages that don't include (or include necessary) php logic.
Those web pages are mostly HTML with some PHP and JavaScript code where needed. Those files are called templates from the pages with the same name located in a root container.

The template directory also includes styles and script files.

Files in this folder are named to be self-explanatory.

#### /templates/js/script.js

A JavaScript file with a jQuery code. It contains code used for dynamic UI. Inside we can find funtions to handle main navigation, dynamic media queries changes, sliders, words counter etc.

#### /templates/src

Src directory in templates has the non dynamic graphics used across the website like temporary avatars, icons, home page background and website logo.

#### /templates/styles

In styles we can find a /sass/ directory, which icludes all the website styles written using the SASS pre-processor and a style.css file which contains a CSS production file with all the styles converted from SASS.

#### /templates/user-dashboard

PHP files with an HTML code that contains mostly forms used to manage users account and interact with users database.

### root directory

The root directory contains PHP files displayed when a URL is provided.
Those files were created to hold a php logic separate from the HTML.
In those files, we open a database connection by creating new classes.
Which classes we call depends on which methods we want to use and what kind of information we need from the database.
Logic depends on what is going on on the page. We validate the form and update the database if it is a register page.
If it is an image page, we receive information from the database.
Thanks to the Template class, all the data is later passed to the pages with HTML as a variable.

#### user_dashboard/delete-account.php

Create a new class instance, "PrivateUser", and connect with the database.
Check user input (sanitize and validate).
The account will be deleted if the user provides a valid email and password twice and clicks submit.
When deleting an account, the user's avatar image will be removed, and all the sessions used to track log-in users will be destroyed.
At the bottom of the file, an instance of the Template class is created to pass variables to the template file and echo a file from templates with an HTML code.

#### user_dashboard/downloads.php

Creates new class instances of "PrivateUser" and "Img" and connects with the database.
Gets results from SQL queries and passes them to the HTML.
At the bottom of the file, an instance of the Template class is created to pass variables to the template file and echo a file from templates with an HTML code.

#### user_dashboard/edit-profile.php

Creates new class instances of "PrivateUser" and "Profiles" and connects with the database.
Sanitizes and Validates user input.
If no errors occur and data does not already exist in the database, the specific columns are updated. At the bottom of the file, an instance of the Template class is created to pass variables to the template file and echo a file from templates with HTML code.

#### user_dashboard/favourites.php

Creates new class instances of "PrivateUser" and "Img" and connects with the database.
Gets results from SQL queries and passes them to the HTML.
At the bottom of the file, an instance of the Template class is created to pass variables to the template file and echo a file from templates with an HTML code.

#### user_dashboard/my-images.php

Creates new class instances of "PrivateUser" and "Img" and connects with the database.
Sanitizes and Validates user input. If no errors occur and data does not already exist in the database, the specific columns are updated.
At the bottom of the file, an instance of the Template class is created to pass variables to the template file and echo a file from templates with HTML code.

#### user_dashboard/upload-image.php

Creates new class instances of "PrivateUser" and "Img" and connects with the database.
Sanitize and Validate a user input. Check if the updated file is a real image file and if the extension matches the allowed file types.
Sets the image file name to the image's title and checks if such a file already exists; if yes, add a set of numbers to the end of the name (DateTime).
Later, I created a thumbnail from the image, prepared data for the database and updated all the info in the database.
At the bottom of the file, an instance of the Template class is created to pass variables to the template file and echo a file from templates with an HTML code.

#### user_dashboard/image.php

Creates new class instances of "PrivateUser", "Img", and "Comment" and connects with the database.
Handle updating downloaded, liked and saved images when the user is logged in.
Those are stored in a database as a string with image IDs separated by "|" like "2|23|15|65|98".
Sanitize and Validate user input while adding comments under the image.
Get a list of related images (looking for images with the same tags).
At the bottom of the file, an instance of the Template class is created to pass variables to the template file and echo a file from templates with an HTML code.

#### user_dashboard/index.php

Creates new class instances of "PublicUser" and "Img" and connects with the database.
Gets results from SQL queries and passes them to the HTML.
At the bottom of the file, an instance of the Template class is created to pass variables to the template file and echo a file from templates with an HTML code.

#### user_dashboard/list.php

Creates new class instances of "SearchSearch" and "Img" and connects with the database.
Gets all strings of tags and converts them into an array.
Later, create a new array with all available tags (without repeating) and sort it at the end.
At the bottom of the file, an instance of the Template class is created to pass variables to the template file and echo a file from templates with an HTML code.

#### user_dashboard/login.php

Creates new class instances of "PrivateUser" and connects with the database.
Sanitize and Validate user input.
Check if the login and encrypted password match the data in the database.
If yes, create a session to manage a logged-in user.
Get the user's IP address and store it in DB.
At the bottom of the file, an instance of the Template class is created to pass variables to the template file and echo a file from templates with an HTML code.

#### user_dashboard/logout.php

Log out of the user by destroying sessions and redirecting the user to the login page.

#### user_dashboard/register.php

Creates new class instances of "PrivateUser" and "Profiles" and connects with the database.
Sanitizes and Validates user inputs. If there are no errors, register a user.
Assigns a temporary avatar based on the first letter of the user's username.
Gets the user's IP address and stores it in the database.
At the bottom of the file, an instance of the Template class is created to pass variables to the template file and echo a file from templates with HTML code.

#### user_dashboard/search.php

Creates new class instances of "PublicUser", "Img", and "SearchSearch" and connects with the database. Declare and assign variables, limit images displayed on one page, and offset variables from the URL (GET).
Sanitize and validate a search phrase/word. Update the database with a searching phrase/word if it already exists, and increase the number of searches.
Add phrase/word to the session to avoid increasing the number of searches in the database too many times.
Calculate the total number of pages needed to display all the results based on the limit from the top of the page.
If POST request, the user manually chooses a number of the result page, sanitizes and validates the input, and gets values from the URL.
Create a new URL and redirect. Create an array of related tags.
Create a default URL and redirect if a search phrase/word was given but other GET values are unavailable.
At the bottom of the file, an instance of the Template class is created to pass variables to the template file and echo a file from templates with an HTML code.

#### user_dashboard/user.php

Creates new class instances of "PublicUser", "Img" and "Profiles" and connect with the database. Gets results from SQL querys and pass them to the HTML.
A the bottom of the file am instance of Template class is created to pass variables to template file and echo a file from templates with an HTML code.
