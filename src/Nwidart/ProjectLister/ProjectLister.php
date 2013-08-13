<?php namespace Nwidart\ProjectLister;

use Config,
    Nwidart\ProjectLister\Lib\Utility,
    Nwidart\ProjectLister\Lib\Project;

class ProjectLister {
    /**
    * The URL of the repository (web-viewable)
    * @var string
    */
    public $url;

    /**
    * The name of the repository
    * @var string
    */
    public $name;

    /**
    * The description of the repo
    * @var string
    */
    public $description;

    /**
    * The watcher count for a repo
    * @var int
    */
    public $watchers;

    /**
    * The source hosting the project.. Like GitHub or BitBucket
    * @var string
    */
    public $source;

    /**
    * If the project has one follower, contains 'watcher'. If 0 or greater
    *  than 1, 'watchers'
    * @var string
    */
    public $watcher_noun;

    /**
    * Date of last repo updated
    * @var int
    */
    public $updated;


    /**
     * Shows the projects as a list (default)
     * @return string Contains the HTML
     */
    public function show()
    {
        $service = Config::get("ProjectLister::service");
        $method = "fetch_$service";
        // Fetch
        $projects = self::$method();
        // Sort the list
        $projects = Project::sort( $projects );

        $output = '';
        foreach($projects as $project)
        {
            $template = ( Config::get("ProjectLister::template") ) ? Config::get("ProjectLister::template") : Project::getProjectTemplate();

            $template = str_replace('{{PROJECT_URL}}', $project->url, $template);
            $template = str_replace('{{PROJECT_NAME}}', htmlentities($project->name), $template);
            $template = str_replace('{{PROJECT_WATCHER_COUNT}}', $project->watchers, $template);
            $template = str_replace('{{PROJECT_DESCRIPTION}}', htmlentities($project->description), $template);
            $template = str_replace('{{PROJECT_SOURCE}}', $project->source, $template);
            $template = str_replace('{{PROJECT_WATCHER_NOUN}}', $project->watcher_noun, $template);

            $output .= $template . "\n";
        }
        return $output;
    }

    /**
     * Fetch project info from github
     * @return array An array of projects
     */
    public static function fetch_github()
    {
        $username = Config::get('ProjectLister::username');

        $projects = array();

        $url  = "https://api.github.com/users/$username/repos";
        $json = Utility::get($url);

        if(!is_array($json = json_decode($json)))
            return FALSE;

        foreach($json as $repo)
        {
            $proj = new ProjectLister;
            $proj->url = $repo->html_url;
            $proj->name = $repo->name;
            $proj->description = $repo->description;
            $proj->watchers = $repo->watchers;
            $proj->source = "GitHub";
            $proj->watcher_noun = ($repo->watchers == 1 ? 'watcher' : 'watchers');
            $proj->updated = strtotime($repo->pushed_at);

            $projects[] = $proj;
        }

        return $projects;
    }

    /**
     * Fetch the projects from BitBucket
     * @return array An array of projects
     */
    public static function fetch_bitbucket($username)
    {
        $username = Config::get('ProjectLister::username');

        $projects = array();

        $url  = "https://api.bitbucket.org/1.0/users/$username/?format=json";
        $json = Project::get($url);

        if(!is_object($json = json_decode($json)))
            return FALSE;

        foreach($json->repositories as $repo)
        {
            $proj = new ProjectLister;
            $proj->url = "https://bitbucket.org/$username/{$repo->slug}";
            $proj->name = $repo->name;
            $proj->description = $repo->description;
            $proj->watchers = $repo->followers_count;
            $proj->source = "BitBucket";
            $proj->watcher_noun = ($repo->followers_count == 1 ? 'watcher' : 'watchers');
            $proj->updated = 0;

            $projects[] = $proj;
        }

        return $projects;
    }

    /**
     * Fetch the projects from Sourceforge
     * @return array An array of projects
     */
    public static function fetch_sourceforge()
    {
        $username = Config::get('ProjectLister::username');

        $projects = array();

        $url  = "http://sourceforge.net/api/user/username/$username/json";
        $json = Project::get($url);

        if(!is_object($json = json_decode($json)))
            return FALSE;

        foreach($json->User->projects as $repo)
        {
            $proj = new ProjectLister;
            $proj->url = "#";
            $proj->name = $repo->unix_name;
            $proj->description = $repo->name;
            $proj->watchers = 1; # The guy who wrote it.. consistent with github
            $proj->source = "SourceForge";
            $proj->watcher_noun = ($proj->watchers == 1 ? 'watcher' : 'watchers');
            $proj->updated = 0;

            $projects[] = $proj;
        }

        return $projects;
    }

}
