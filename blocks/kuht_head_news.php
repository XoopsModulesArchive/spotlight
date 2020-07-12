<?php
/**
 * $Id: kuht_head_news.php, v 2.0 12 March 2004 catzwolf Exp $
 * Module: Spotlight
 * Version: v2.0
 * Release Date: 12 March 2004
 * Author: Catzwolf
 * Orginal Author: Herko (me at herkocoomans dot net) and    
 * 				   Dawilby (willemsen1 at chello dot nl)
 * Licence: GNU
 */

include_once XOOPS_ROOT_PATH . "/modules/spotlight/include/functions.php";
include_once XOOPS_ROOT_PATH . "/modules/news/class/class.newsstory.php";

/**
 * b_head_kuht_show_news()
 * 
 * @param  $options 
 * @return 
 */
function b_head_kuht_show_news($options)
{
    $block = array(); 

    global $xoopsDB, $xoopsConfig, $myts, $xoopsModuleConfig, $xoopsModule;

    $myts = &MyTextSanitizer::getInstance();

    $modhandler = &xoops_gethandler('module');
    $xoopsModule = &$modhandler->getByDirname("spotlight");
    $config_handler = &xoops_gethandler('config');
    $xoopsModuleConfig = &$config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

    /**
     * Mini Spotlights
     */
	$minis_handler =& xoops_getmodulehandler('mini', 'spotlight');
	if( $minis =& $minis_handler->getObjects() ){
		$block['mini'] = array();
		$excludes = array();
		foreach( $minis as $m ){
			if( $m->getVar('published') > 0 && $m->getVar('published') < time() &&
				($m->getVar('expired') > time() || $m->getVar('expired') == 0)
			){
				$topicid= $m->getVar('topicid');


				/**
				 * Getting the latest  topic under which the post is made.
 			 	 */
				  $current_news_topic = $xoopsDB->query("SELECT topicid, title FROM " . $xoopsDB->prefix("stories") . " WHERE published > 0 AND published < " . time() . " AND (expired > " . time() . " OR expired = 0) ORDER BY published DESC", 1, 0);
      				  list($latest_topicid) = $xoopsDB->fetchRow($current_news_topic);

				if ($latest_topicid != $topicid) {	

					/**
					 * Getting the latest news under each topic that is selected as to be shown.
 					 */
					$mini_news = $xoopsDB->query("SELECT storyid  FROM " . $xoopsDB->prefix("stories") . " WHERE topicid = ". $topicid ." AND published > 0 AND published < " . time() . " AND (expired > " . time() . " OR expired = 0) ORDER BY published DESC", 1, 0);
			        	list($mini_news_id) = $xoopsDB->fetchRow($mini_news);

               				if (isset($mini_news_id) and $mini_news_id > 0) {
		                        	$news_article = new NewsStory($mini_news_id);
                			}
					$storyid = $news_article->storyid;
					$mini_text_content=$m->getVar('mini_text');
					if (strlen($mini_text_content)>0 ) {
					$mini_news_text=$m->getVar('mini_text');
					} else {
						$mini_news_text=$news_article->hometext();
					} 

				        	$mini_news_text = preg_replace("/(\<img)(.*?)(\>)/si", "", $mini_news_text);

					$mini_news_text=substr($mini_news_text,0,400) ."...";

					$block['mini'][$storyid] = array(
										'storyid' => $storyid,
										'text' =>$mini_news_text,
										'img' => $m->getVar('mini_img'),
										'align' => $m->getVar('mini_align') ? 'right' : 'left'
										);
					$excludes[] = $storyid ;
				}
			}
		}
	}

    $fhometext = "";
    $image_align = "";

    $block['title_news'] = _MB_KUHT_TITLE_SPOTLIGHT_NEWS;
    $block['lang_by'] = _MB_KUHT_BY;
    $block['lang_read'] = _MB_KUHT_READ;
    $block['lang_comments'] = _MB_KUHT_COMMENTS;
    $block['lang_write'] = _MB_KUHT_WRITE;

    /**
     * Main spotlight database information
     */
    $sql = "SELECT * FROM " . $xoopsDB->prefix('spotlight') . " WHERE sid = 1";
    $spot_arr = $xoopsDB->fetchArray($xoopsDB->query($sql));
	
    if (isset($spot_arr['auto']) && $spot_arr['auto'] == 0)
    { 
        // Selects user choosen news
        $article = new NewsStory($spot_arr['item']);
    } else {
	
	
	}
    
    if (isset($spot_arr['auto']) && $spot_arr['auto'] == 1)
    { 
		// selects the last addition to news
        $result2 = $xoopsDB->query("SELECT storyid, title FROM " . $xoopsDB->prefix("stories") . " WHERE published > 0 AND published < " . time() . " AND (expired > " . time() . " OR expired = 0) ORDER BY published DESC", 1, 0);
        list($fsid, $ftitle) = $xoopsDB->fetchRow($result2);
        
		if (isset($fsid) and $fsid > 0) {
			$article = new NewsStory($fsid);
		}
    }

    if (!isset($article->storyid) && $article->storyid > 0)
    {
        $block['storyid'] = 0;
        $block['newstitle'] = _MB_KUHT_NOTSELECT;
    }
    else
    { 
        // images
        if ($spot_arr['auto_image'])
        {
            $xt = new XoopsTopic($xoopsDB->prefix('topics'), $article->topicid());
            $block['image'] = $xt->topic_imgurl("S");
            $block['imgpath'] = "/modules/news/images/topics/";
        }
        else
        {
            $block['image'] = $myts->htmlSpecialChars(trim($spot_arr['image']));
            $block['imgpath'] = $myts->htmlSpecialChars(trim($xoopsModuleConfig['uploaddir']));
        }

        if (!empty($block['image']))
        {
            $block['imgwidth'] = $xoopsModuleConfig['dmaximgwidth'];
            $block['imgheight'] = $xoopsModuleConfig['dmaximgheight'];

            if ($xoopsModuleConfig['retainimgsize'])
            {
                $dimention = getimagesize(XOOPS_ROOT_PATH . "/{$block['imgpath']}/{$block['image']}");
                $block['imgwidth'] = $dimention[0];
                $block['imgheight'] = $dimention[1];
            }

            if ($xoopsModuleConfig['newsthumbs'])
            {
                $block['image'] = spot_createthumb($block['image'], XOOPS_ROOT_PATH, "/" . $block['imgpath'] . "/", "thumbs/", $xoopsModuleConfig['dmaximgwidth'], $xoopsModuleConfig['dmaximgheight'], $xoopsModuleConfig['imagequality'] , $xoopsModuleConfig['updatethumbs']);
                $block['image'] = "thumbs/" . basename($block['image']);
            }
        }
        $block['imagealign'] = $spot_arr['imagealign']; 
        // news title
        $ftitle = $article->title();
        if (strlen($ftitle) >= $xoopsModuleConfig['titlelenght'])
        {
            $ftitle = xoops_substr($ftitle, 0, $xoopsModuleConfig['titlelenght'], $trimmarker = '...');
        }
        $block['newstitle'] = $xoopsModuleConfig['stopshouting'] ? spot_removeShouting($ftitle) : $ftitle; 
        // end
        $fhometext = $article->hometext();
        if ($xoopsModuleConfig['remimgmain'])
        {
            $fhometext = preg_replace("/(\<img)(.*?)(\>)/si", "", $fhometext);
        }
        $block['hometext_news'] = trim($fhometext);
        $block['author'] = xoops_getLinkedUnameFromId(intval($article->uid()));
        $block['storyid'] = $article->storyid();
        $block['comments'] = $article->comments();
    }

    if ($xoopsModuleConfig['showmoreart'])
    {
        $block['lang_other_news'] = _MB_KUHT_OTHER_NEWSTEXT;

        $news = array();
        $sarray = NewsStory::getAllPublished($xoopsModuleConfig['perpage'], 0, 0);
        $news = '';
        foreach ($sarray as $article)
        {
            if ( $article->storyid() != $block['storyid'] &&
            	!in_array($article->storyid(), $excludes) )
            {
                $news['id'] = $article->storyid();
                $title = $article->title();
                if (strlen($title) > $xoopsModuleConfig['textchars'])
                {
                    $title = xoops_substr($title, 0, $xoopsModuleConfig['titlelenght'], $trimmarker = '...');
                }
                $news['title'] = spot_removeShouting($title);
                $news['hitsordate'] = ($options[0] == "published") ? formatTimestamp($article->published(), "s"): $article->counter();
                if ($xoopsModuleConfig['showteaser'])
                {
                    $fhometext = $article->hometext();

                    if ($xoopsModuleConfig['textchars'] > 0)
                    {
                        if (strlen($fhometext) > $xoopsModuleConfig['textchars'])
                        {
                            $fhometext = xoops_substr($fhometext, 0, $xoopsModuleConfig['textchars'], $trimmarker = '...');
                        }
                    }
                    if ($xoopsModuleConfig['remimgmain'])
                    {
                        $fhometext = preg_replace("/(\<img)(.*?)(\>)/si", "", $fhometext);
                    }
                    $news['hometext'] = trim($fhometext);
                }
                else
                {
                    $news['hometext'] = '';
                }
                $block['stories'][] = $news;
            }
        }
    }

    if ($xoopsModuleConfig['showtopicbox'])
    { 
        // rb topic select form for news direct topic access
        include_once XOOPS_ROOT_PATH . "/class/xoopstopic.php";
        $xt = new XoopsTopic($xoopsDB->prefix("topics"));
        $jump = XOOPS_URL . "/modules/news/index.php?storytopic=";
        $storytopic = !empty($storytopic) ? intval($storytopic) : 0;
        ob_start();
        $xt->makeTopicSelBox(1, $storytopic, "storytopic", "location=\"" . $jump . "\"+this.options[this.selectedIndex].value");
        $block['topicsel'] = ob_get_contents();
        ob_end_clean();
    }

    if ($xoopsModuleConfig['ministats'])
    {
        $block['lang_ministats'] = '<span style="text-transform: uppercase">' . _MB_KUHT_MINISTATS . ':</span>';

        $result = $xoopsDB->query("select sum(counter) FROM " . $xoopsDB->prefix("stories") . "");
        list($storiesviews) = $xoopsDB->fetchRow($result);
        $result = $xoopsDB->query("SELECT sum(comments) FROM " . $xoopsDB->prefix("stories") . "");
        list($comment) = $xoopsDB->fetchRow($result);

        $block['ministats'] = _MB_KUHT_PUBLISHED . ': <b>' . $article->countPublishedByTopic() . ' :</b> ' . "\n";
        $block['ministats'] .= _MB_KUHT_READS . ': <b>' . $storiesviews . '</b> : ' . "\n";
        $block['ministats'] .= _MB_KUHT_NEWSCOMMENTS . ': <b>' . $comment . '</b>' . "\n";
    }

    if ($xoopsModuleConfig['templatetype'])
    {
        $block['select_template'] = 1;
    }
    return $block;
}

function b_head_kuht_edit_news($options)
{
    $form .= _MB_KUHT_ORDER . ' <select name="options[0]">' . "\n";
    $form .= '<option value="published"';
    if ($options[0] == "published")
    {
        $form .= ' selected="selected"';
    }
    $form .= '>&nbsp;' . _MB_KUHT_DATE . '</option>' . "\n";
    $form .= '<option value="counter"';
    if ($options[0] == "counter")
    {
        $form .= ' selected="selected"';
    }
    $form .= '>&nbsp;' . _MB_KUHT_HITS . '</option>' . "\n";
    $form .= '</select><br />' . "\n";
    return $form;
}

?>
