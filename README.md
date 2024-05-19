<h1 align="center"> Trinted </h1>

## Group ltw15g02

- Bruno Ricardo Soares Pereira de Sousa Oliveira (up202208700) 33%
- Henrique Sardo Fernandes (up202204988) 33%
- Rodrigo Albergaria Coelho e Silva (up202205188) 33%

## Install Instructions

```shell
git clone <your_repo_url>
git checkout final-delivery-v1
sqlite database/database.db < database/script.sql
php -S localhost:9000
```

## External Libraries

We have used the following external libraries:

- php-gd

## Screenshots

(2 or 3 screenshots of your website)

## Implemented Features

**General**:

- [X] Register a new account.
- [X] Log in and out.
- [X] Edit their profile, including their name, username, password, and email.

**Sellers**  should be able to:

- [ ] List new items, providing details such as category, brand, model, size, and condition, along with images.
- [ ] Track and manage their listed items.
- [X] Respond to inquiries from buyers regarding their items and add further information if needed.
- [X] Print shipping forms for items that have been sold.

**Buyers**  should be able to:

- [X] Browse items using filters like category, price, and condition.
- [X] Engage with sellers to ask questions or negotiate prices.
- [X] Add items to a wishlist or shopping cart.
- [X] Proceed to checkout with their shopping cart (simulate payment process).

**Admins**  should be able to:

- [X] Elevate a user to admin status.
- [X] Introduce new item categories, sizes, conditions, and other pertinent entities.
- [X] Oversee and ensure the smooth operation of the entire system.

**Security**:

We have been careful with the following security aspects:

- [X] **SQL injection**
- [X] **Cross-Site Scripting (XSS)**
- [X] **Cross-Site Request Forgery (CSRF)**

**Password Storage Mechanism**: md5 / sha1 / sha256 / hash_password&verify_password

**Aditional Requirements**:

We also implemented the following additional requirements:

- [X] **Analytics Dashboard**
- [X] **API Integration**
- [X] **User Preferences**
- [X] **Shipping Costs**
- [X] **Real-Time Messaging System**
- [X] **PHP Framework**

---

## PHP Framework

This project features a simple PHP Framework with interesting features better described below:

- **Class Autoloading**: PHP classes which are declared under the directories specified in the Autoload file can be automatically loaded into the code. For this to work, their file name should also be {class-name}.php
- **Routing**: Instead of completely loading different php files, the index.php extracts the path from the URL and redirects it to an already defined route (if it exists). If the route is defined, a new controller will be created to execute an action. This action is the resposnse which will generate the page content
- **Requests**: To better encapsulate PHP superglobals, when a new request is made, a Request object is created storing all the relevant superglobals. This request is then passed to the controller for it to be handled accordingly.
- **Middleware**: Middlewares are basically checks that occur between requests. When accessing certain routes, there may be some middlewares that will receive a request and conditionally decide if the Request should continue or return a different Request

### How to use the framework:

After the framework is created, the way to use it follows a list of simple steps:
1. Create a new route for the new page
2. Create the controller action to generate the page content (possibly calling a function from the pages directory)
3. If there is any request logic involved, either handle it in the controller or pass the request to the page loader
4. If there are necessary middlewares, add them to the route array and, if needed, implement them in the middlewares folder by implementing the Middleware interface

Note: since the autoloader is enabled in index.php, if new classes are created, we can update the file for them to be loaded when necessary as well

## Dependencies

1. https://archlinux.org/packages/extra/x86_64/php-gd/ (this one im not sure)
2. Open the php.ini file (usually located in /etc/php/php.ini, you can find the location by running `php --ini`)
3. Uncomment the line `extension=gd`