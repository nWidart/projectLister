# Project Lister

Project lister is a package to display a list of your current repositories on Github, Bitbucket or Sourceforge. 

## Installation

Add `nwidart/ProjectLister` as a requirement to `composer.json`:

```
{
    ...
    "require": {
        ...
        "nwidart/ProjectLister": "dev-master"
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
$ php artisan config:publish nwidart/ProjectLister
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
5. `template` : You can override the default template here. These variables are available:
	6. `{{PROJECT_URL}}` :  The project URL
	2. `{{PROJECT_NAME}}` : The project Name
	3. `{{PROJECT_WATCHER_COUNT}}` : The project watchers count
	4. `{{PROJECT_DESCRIPTION}}` : The project description
	5. `{{PROJECT_WATCHER_NOUN}}` : Is replaced by 'watcher' or 'watchers'

## Usage
The show the projects list simple use this in one of your views:

    {{ ProjectLister::show(); }}