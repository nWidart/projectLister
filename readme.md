# Project Lister

Project lister is a package to display a list of your current repositories on Github, Bitbucket or Sourceforge. 

## Installation

Add `nwidart/ProjectLister` as a requirement to `composer.json`:

```
{
    ...
    "require": {
        ...
        "nwidart/project-lister": "dev-master"
    },
}
```

Update composer:

```
$ php composer.phar update
```

Add `'Nwidart\ProjectLister\ProjectListerServiceProvider',` to your `app/config/app.php` file in the `providers` array.



Publish package config:

```
$ php artisan config:publish nwidart/project-lister
```


## Configuration

In the `app/config/nwidart/projectLister/config.php` config file:

1. `service` : Set your desired service (github,bitbucket,sourceforge)
2. `username` : Set your username on that service
3. `sortBy` : You can set the sort type. Possible options are:
	4. `Watchers`
	2. `Name`
	3. `Updated`
4. `sortByAsc` : true/false. Set if you wish to sort ascending or not.
5. `template` : You can override the default template here. These tags are available:
	6. `{{PROJECT_URL}}` :  The project URL
	2. `{{PROJECT_NAME}}` : The project Name
	3. `{{PROJECT_WATCHER_COUNT}}` : The project watchers count
	4. `{{PROJECT_DESCRIPTION}}` : The project description
	5. `{{PROJECT_WATCHER_NOUN}}` : Is replaced by 'watcher' or 'watchers'

## Usage
To show the projects list simple use this in one of your views:

    {{ ProjectLister::show(); }}
    
## Credits

This is mainly a port of the Wordpress Plugin [github-bitbucket-project-lister](http://wordpress.org/plugins/github-bitbucket-project-lister/), to be used in Laravel.


## License (MIT)


Copyright (C) 2012 by Kenny Katzgrau <katzgrau@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.