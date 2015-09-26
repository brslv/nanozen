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

Here's a custom route, responding to a HTTP GET request on */hi* to the HomeController::welcome() method:

```
$router->get('/hi', 'HomeController@hi');
```
You can also use parameters. Here's how:

```
$router->get('/users/{id:i}', 'UsersController@show');
```
The route above is a bit special. It can respond to a HTTP GET request on */users/1*. Also on a HTTP GET request on */users/2*. So, the {id:i} part of the route can be any number (integer). That's the role of the **:i** flag here. It represents integer type of value. So the route */users/john* won't match. We can use the provided parameter as an argument in the UsersController::show() method. 

#### The flag thing
Other then the **:i** flag, you can use other flags after your parameter's name. The out of the box once are:

- **:s** - for strings;
- **:a** - for anything;

The thing is you should always pass a flag:

**WRONG:**
```
// Wrong:
$router->get('/users/{id}', ...);

// Right:
$router->get('/users/{id:i}, ...);
$router->get('/users/{name:s}, ...);
$router->get('/users/{moto:a}', ...);
```
If you want a custom tag, you can create one runtime. Like this:

```
// $router->addPattern(<alias>, <regex>);
$router->addPattern(':b', '#[bB]#'); // this route matches only b/B as parameter 
```

And after this line, use the newly created flag:

```
$router->get('/users/{name:b}', 'UserController@showBobysProfile');
```
#### Optional parameters
The framework provides the user with ability to pass optional parameters, by simply appending **?**:

```
$router->get('/users/{name:s?}') // name is optional here
```