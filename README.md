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

> your-cool-app.com/*controller/action/parameter-1/parameter-2/parameter-n/*

#### Custom routing
Nanozen also provides the user with a way to specify custom routes. This can be done directly from the **routes** file in the root directory.

Here's a custom route, responding to a HTTP GET request on */hi* uri, using the HomeController::welcome() method:

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
$router->get('/users/{id}', 'UsersController@show');

// Right:
$router->get('/users/{id:i}, 'UsersController@show');
$router->get('/users/{name:s}, 'UsersController@show');
$router->get('/users/{moto:a}', 'UsersController@show');
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
$router->get('/users/{name:s?}'); // name is optional here
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

> your-cool-app.com/forum/home/welcome

*Custom routing for areas*
Area routes can be customized, too. Let's say you want the HomeController::welcome() action to respond on the uri:

> your-cool-app.com/forum/hi

To do this, go to the app's routes file and make a route for this area:

```php
$router->forArea('forum')->get('/', 'HomeController@welcome');
```

### Areas
Areas, as we said above, are kind of bundles for a specific functionality for your app - such as a forum. It's like an app in the app. 

Areas have their own controllers, views and models. 

#### Making an area
There's nothing magical.You make a folder in the framework's Areas folder. Let's say we want to make a gallery area. So we make a Gallery folder in Areas. Now:

*Make Controllers folder.* 
To use all the functionalities the framework provides you with, you should wrap yourself the BaseAreasControllerProvider in your custom BaseController.

Do the following:

```php
<?php

class GalleryBaseController extends BaseAreasControllerProvider
{
	protected $viewsPathForThisArea = '../Areas/Gallery/Views/';
	
	protected function view()
	{	
		$this->viewProviderContract->setPath($this->viewsPathForThisArea);
		
		return parent::view();
	}
}
```
The code above creates a base controller for your area/module/bundle/whatever-you-call-it, which should be extended by every other controller in your custom area. Here you instruct all your area controllers to use '../Areas/Gallery/Views/'. That's it. Now each new controller, extending this base wrapper class, has the ability to call views, to use database and all the flavour the framework provides you with.

*Make Models folder*
Here you will manage your area's models.

*Make Views folder*
Here you will manage all your area's views.

#### Initializing an area
The important thing for the areas is that you must initialize a route in order for an area to work and to be visible to the public. You do this in the routes file like this:

```php
// Initialize the forum area, located in the Forum folder (under app's Areas folder)
$router->area('forum', 'Forum');
```
#### Routing an area
You can read more about routing for a custom area in the **Routing** section above.
