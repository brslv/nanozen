# nanozen
Nanozen is a php framework, created as part of my SoftUni project for the PHP Web Development course.

It's not fully functional and may have some bugs, but it has the core components every modern framework has:

* Default and custom routing;
* Areas (Bundles);
* Model binging;
* Strongly typed views;
* Database abstraction layer;
* More...

## Documentation

### Routing

#### Default routing
The framework has a default routing mechanism, following the pattern.

> http://website.com/*controller/action/parameter-1/parameter-2/parameter-n/*

#### Custom routing
Nanozen also provides the user with a way to specify custom routes. This can be done directly from the **routes** file in the route directory.

Here's a custom route, responding to a HTTP GET request on */hi*, using the HomeController::welcome() method:

```php
$router->get('/hi', 'HomeController@welcome');
```
You can also use parameters. Here's how:

```php
$router->get('/users/{id:i}', 'UsersController@show');
```
The route above is a bit special. It can respond to a HTTP GET request on */users/1*. Also on a HTTP GET request on */users/2*. So, the {id:i} part of the route can be any number (integer). That's the role of the **:i** flag here. It represents integer type of value. So the route */users/john* won't match. We can use the provided parameter as an argument in the UsersController::show() method. 

#### The flag thing
Other then the **:i** flag, you can use other flags after your parameter's name. The out of the box once are:

- **:s** - for strings;
- **:a** - for anything;
- **:i** - as said above - for integers;

The thing is you should always pass a flag:

```php
// Wrong:
$router->get('/users/{id}', ...);

// Right:
$router->get('/users/{id:i}, ...);
$router->get('/users/{name:s}, ...);
$router->get('/users/{moto:a}', ...);
```
If you want a custom tag, you can create one runtime. Like this:

```php
// $router->addPattern(<alias>, <regex>);
$router->addPattern(':b', '#[bB]#'); // this route matches only b/B as parameter 
```

And after this line, use the newly created flag:

```php
$router->get('/users/{name:b}', 'UserController@showBobysProfile');
```
#### Optional parameters
The framework provides the user with ability to pass optional parameters, by simply appending **?**:

```php
$router->get('/users/{name:s?}') // name is optional here
```

#### Routing for areas
Areas are a nice way to group up certain components for your application. E.g. a forum component can be bundled in a custom area. We discuss areas bellow. Now, let's look at how to route them:

*Initializin area*
First, you should tell your app that it has an area, that is ready to be seen by the world. Do it like this:

```php
// in routes.php
$router->area('forum', 'Forum');
```
The first argument is the name of the route prefix. The second is the name of the folder the area is located. In our case it's the *Forum* folder inside the app's *Areas* folder.

*Default routing for areas*
Areas come with default routing. That said, an area, called *forum*, has a prefix of forum in the url. So, the HomeController::welcome() method in the forum area is dispatched automatically on the following uri:

> http://your-cool-app.com/forum/home/welcome

*Custom routing for areas*
Area routes can be customized, too. Let's say you want the HomeController::welcome() action to respond on the uri:

> http://your-cool-app.com/forum/hi

To do this, go to the app's routes file and make a route for this area:

```php
$router->forArea('forum')->get('/', 'HomeController@welcome');
```