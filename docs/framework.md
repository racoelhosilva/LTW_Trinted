
## PHP Framework (initial implementation)

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
