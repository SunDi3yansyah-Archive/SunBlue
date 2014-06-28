<?php 
/**
 * MyBB 1.6
 * Copyright 2010 MyBB Group, All Rights Reserved
 * Custom page by. SunDi3yansyah dan Ambrizal
 * Website: http://www.kampoeng.co.id/
 */
define('IN_MYBB', 1); require "./global.php";
require_once MYBB_ROOT."inc/functions_post.php";
require_once MYBB_ROOT."inc/functions_user.php";
require_once MYBB_ROOT."inc/class_parser.php";
$lang->load("stats");
$parser = new postParser;
$tlimit = 5;
$allimit = 15;

$allimit = 5;
   $query = $db->query("
SELECT t.*, u.username
FROM threads t
LEFT JOIN users u ON ( u.uid = t.uid )
WHERE t.visible = '1'
AND t.closed NOT LIKE 'moved|%'
ORDER BY t.views DESC
LIMIT $allimit");
   
   while($thread = $db->fetch_array($query))
   {
$postdate = my_date($mybb->settings['dateformat'], $thread['dateline']);
$numberbit = $thread['views'];
$numbertype = 'Kali';
$thread['subject'] = htmlspecialchars_uni($parser->parse_badwords($thread['subject']));
       $thread['threadlink'] = get_thread_link($thread['tid']);
       eval("\$hotthread .= \"".$templates->get("custom_stats_thread")."\";");
       $altbg = alt_trow();
    }
// Thread Terbaru dari Forum Semua

    $query = $db->query("SELECT * FROM ".TABLE_PREFIX."threads ORDER BY `tid` DESC LIMIT $allimit");
    
    $listall = '';
    while($fetch = $db->fetch_array($query))
    {
        $listall .= "<li><a href=\"showthread.php?tid={$fetch['tid']}\" target=\"_parent\">".htmlspecialchars_uni($fetch['subject'])."</a></li>";
    }
// Thread Terbaru dari semua forum
    $altbg = alt_trow();
    $limit = 5;
    $query = $db->query("
    SELECT * FROM ".TABLE_PREFIX."threads ORDER BY `tid` 
    DESC LIMIT $limit");
    
    while($thread = $db->fetch_array($query))
    {
        $lastpostdate = my_date($mybb->settings['dateformat'], $thread['lastpost']);
        $lastposterlink = $thread['lastposter'];
        
        $threadprefix = '';
        if($thread['prefix'] != 0)
        {
            $threadprefix = build_prefixes($thread['prefix']);
            $thread['threadprefix'] = $threadprefix['displaystyle'].'&nbsp;';
        }

            $thread['subject'] = htmlspecialchars_uni($parser->parse_badwords($thread['subject']));
        $thread['threadlink'] = get_thread_link($thread['tid'], 0, "lastpost");
        $thread['lastpostlink'] = get_thread_link($thread['tid'], 0, "lastpost");
        eval("\$latest .= \"".$templates->get("latestpost")."\";");
        $altbg = alt_trow();
     } 
	 
// Most replied threads
$most_replied = $cache->read("most_replied_threads");
if(!$most_replied)
{
    $cache->update_most_replied_threads();
    $most_replied = $cache->read("most_replied_threads", true);
}
if(!empty($most_replied))
{
    $maxrows = 0;
    foreach($most_replied as $key => $thread)
    {
        if(!in_array("'{$thread['fid']}'", $unviewableforumsarray))
        {
            $thread['subject'] = htmlspecialchars_uni($parser->parse_badwords($thread['subject']));
            if(strlen($thread['subject']) > 40)
            {
                $thread['subject'] = substr($thread['subject'],0,40)."...";
            }
            $numberbit = my_number_format($thread['replies']);
            $numbertype = $lang->replies;
            $thread['threadlink'] = get_thread_link($thread['tid']);
            eval("\$mostreplies .= \"".$templates->get("forums_popular_thread")."\";");
            
            $maxrows++;
        }
        if($maxrows > 7) break;
    }
}
// End most replied threads
eval("\$html = \"".$templates->get("beranda")."\";"); 
output_page($html);
?>