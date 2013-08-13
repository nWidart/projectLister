<?php namespace Nwidart\ProjectLister\Lib;

use Config;

class Project {

    public static function getProjectTemplate()
    {
$template = <<<TEMP
<ul>
    <li>
        <h4>
            <a href="{{PROJECT_URL}}">
                {{PROJECT_NAME}}
            </a>
        </h4>
        <p>{{PROJECT_DESCRIPTION}} <small>({{PROJECT_WATCHER_COUNT}} {{PROJECT_WATCHER_NOUN}})</small></p>
    </li>
</ul>
TEMP;
        return $template;
    }

    public static function sort( $projects )
    {
        $sortType = Config::get('ProjectLister::sortBy');
        if($sortType && is_callable(array(__CLASS__, "sortBy$sortType")))
        {
            $sorter = "sortby$sortType";

            $projects = self::$sorter($projects, (Config::get('ProjectLister::sortByAsc') == 'true' ) ? true : false );
        }
        return $projects;
    }

    /**
     * Sort a list of projects by watchers using PHP's usort
     * @param array[WPGH_Project] $projects
     * @param bool $is_asc
     * @return array[WPGH_Project]
     */
    private static function sortByWatchers($projects, $is_asc = TRUE)
    {
        if($is_asc)
            usort($projects, array(__CLASS__, 'compareWatchersAsc'));
        else
            usort($projects, array(__CLASS__, 'compareWatchersDesc'));

        return $projects;
    }

    /**
     * Compare the watchers for ascending order
     * @param WPGH_Project $p1
     * @param WPGH_Project $p2
     * @return array
     */
    public static function compareWatchersAsc($p1, $p2)
    {
        return $p1->watchers < $p2->watchers ? -1 : 1;
    }

    /**
     *
     * Compare the watchers for descending order
     * @param WPGH_Project $p1
     * @param WPGH_Project $p2
     * @return array
     */
    public static function compareWatchersDesc($p1, $p2)
    {
        return $p1->watchers > $p2->watchers ? -1 : 1;
    }

    /**
     * Sort a list of projects by name using PHP's usort
     * @param array[WPGH_Project] $projects
     * @param bool $is_asc
     * @return array[WPGH_Project]
     */
    public static function sortByName($projects, $is_asc = TRUE)
    {
        if($is_asc)
            usort($projects, array(__CLASS__, 'compareNamesAsc'));
        else
            usort($projects, array(__CLASS__, 'compareNamesDesc'));

        return $projects;
    }

    /**
     * Compare the names for ascending order
     * @param WPGH_Project $p1
     * @param WPGH_Project $p2
     * @return array
     */
    public static function compareNamesAsc($p1, $p2)
    {
        return strtolower($p1->name) < strtolower($p2->name) ? -1 : 1;
    }

    /**
     *
     * Compare the names for descending order
     * @param WPGH_Project $p1
     * @param WPGH_Project $p2
     * @return array
     */
    public static function compareNamesDesc($p1, $p2)
    {
        return strtolower($p1->name) > strtolower($p2->name) ? -1 : 1;
    }

    /**
     * Sort a list of projects by time last updated using PHP's usort
     * @param array[WPGH_Project] $projects
     * @param bool $is_asc
     * @return array[WPGH_Project]
     */
    public static function sortByUpdated($projects, $is_asc = TRUE)
    {
        if($is_asc)
            usort($projects, array(__CLASS__, 'compareUpdatedAsc'));
        else
            usort($projects, array(__CLASS__, 'compareUpdatedDesc'));

        return $projects;
    }

    /**
     * Compare the time last updated for ascending order
     * @param WPGH_Project $p1
     * @param WPGH_Project $p2
     * @return array
     */
    public static function compareUpdatedAsc($p1, $p2)
    {
        return $p1->updated < $p2->updated ? -1 : 1;
    }

    /**
     *
     * Compare the time last updated for descending order
     * @param WPGH_Project $p1
     * @param WPGH_Project $p2
     * @return array
     */
    public static function compareUpdatedDesc($p1, $p2)
    {
        return $p1->updated > $p2->updated ? -1 : 1;
    }
}
