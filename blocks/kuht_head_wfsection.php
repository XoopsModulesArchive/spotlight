<?php
/**
 * $Id: kuht_head_wfsection.php, v 2.0 12 March 2004 catzwolf Exp $
 * Module: Spotlight
 * Version: v2.0
 * Release Date: 12 March 2004
 * Author: Catzwolf
 * Orginal Author: Herko (me at herkocoomans dot net) and    
 * 				   Dawilby (willemsen1 at chello dot nl)
 * Licence: GNU
 */

include_once(XOOPS_ROOT_PATH . '/class/module.textsanitizer.php');
include_once XOOPS_ROOT_PATH . "/modules/spotlight/include/functions.php";

function b_head_kuht_show_wfsection($options)
{
    global $xoopsDB, $xoopsConfig, $myts, $xoopsModuleConfig, $xoopsModule;

    $myts = &MyTextSanitizer::getInstance();

    $modhandler = &xoops_gethandler('module');
    $xoopsModule = &$modhandler->getByDirname("spotlight");
    $config_handler = &xoops_gethandler('config');
    $xoopsModuleConfig = &$config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

    $fhometext = "";
    $block = array();

    $block['title_wfsection'] = _MB_KUHT_TITLE_SPOTLIGHT_WFSS;
    $block['lang_by'] = _MB_KUHT_AUTORE;
    $block['lang_read'] = _MB_KUHT_READ;
    $block['lang_rating'] = _MB_KUHT_RATING;
    $block['lang_write'] = _MB_KUHT_WRITE; 
    /*
	*  Main spotlight database information
	*/ 
    $result = $xoopsDB->query("SELECT item, auto, image, auto_image, imagealign FROM " . $xoopsDB->prefix("spotlight") . " WHERE sid = 2", 1, 0);
    list ($item, $auto, $image, $auto_image, $imagealign) = $xoopsDB->fetchRow($result);

    if ($auto == 0)
    { 
        // no auto selection
        $result = $xoopsDB->query("SELECT articleid, uid, title, maintext, summary, TRUNCATE(rating,1), nohtml, nosmiley, noxcodes, nobreaks  FROM " . $xoopsDB->prefix("wfs_article") . " WHERE articleid=" . $item . " ", 1, 0);
    }
    else
    { 
        // auto selection
        $result = $xoopsDB->query("SELECT articleid, uid, title, maintext, summary, TRUNCATE(rating,1), nohtml, nosmiley, noxcodes, nobreaks FROM " . $xoopsDB->prefix("wfs_article") . " WHERE published < " . time() . " AND published > 0 AND (expired = 0 OR expired > " . time() . ") AND noshowart = 0 ORDER BY published DESC", 1, 0);
    }
    list ($fsid, $fautore, $ftitle, $fmaintext, $fsummary, $frating, $fnohtml, $fnosmiley, $fnoxcodes, $fnobreaks) = $xoopsDB->fetchRow($result);

    $result2 = $xoopsDB->query("SELECT uname, uid FROM " . $xoopsDB->prefix("users") . " WHERE uid=" . $fautore . "", 1, 0);
    list ($fautorevero, $uidutente) = $xoopsDB->fetchRow($result2);

    if (!$fsid && !$ftitle)
    {
        $block['message'] = _MB_KUHT_NOTSELECT;
    }
    else
    {
        if ($auto_image)
        {
            $var_image = $xoopsDB->query("SELECT categoryid FROM " . $xoopsDB->prefix("wfs_article") . " WHERE articleid=" . $fsid . "", 1, 0);
            list ($patt_image) = $xoopsDB->fetchRow($var_image);

            $var_image2 = $xoopsDB->query("SELECT imgurl FROM " . $xoopsDB->prefix("wfs_category") . " WHERE id=" . $patt_image . "", 1, 0);
            list ($image_display) = $xoopsDB->fetchRow($var_image2);

            $var_image3 = $xoopsDB->query("SELECT sgraphicspath FROM " . $xoopsDB->prefix("wfs_config") . " ");
            list ($image_path) = $xoopsDB->fetchRow($var_image3);

            $block['image'] = $myts->htmlSpecialChars(trim($image_display));
            $block['imgpath'] = $image_path;
        }
        else
        {
            $block['image'] = $myts->htmlSpecialChars(trim($image));
            $block['imgpath'] = $myts->htmlSpecialChars($xoopsModuleConfig['wfuploaddir']);
        }

        if (!empty($block['image']))
        {
            $dimention = getimagesize(XOOPS_ROOT_PATH . "/{$block['imgpath']}/{$block['image']}");

            if ($xoopsModuleConfig['wfretainimgsize'])
            {
                $dimention = getimagesize(XOOPS_ROOT_PATH . "/{$block['imgpath']}/{$block['image']}");
                $block['imgwidth'] = $dimention[0];
                $block['imgheight'] = $dimention[1];
            }
            else
            {
                $block['imgwidth'] = $xoopsModuleConfig['wfdmaximgwidth'];
                $block['imgheight'] = $xoopsModuleConfig['wfdmaximgheight'];
            }

            if ($xoopsModuleConfig['wfssthumbs'])
            {
                $block['image'] = spot_createthumb($block['image'], XOOPS_ROOT_PATH, "/" . $block['imgpath'] . "/", "thumbs/", $xoopsModuleConfig['wfdmaximgwidth'], $xoopsModuleConfig['wfdmaximgheight'], $xoopsModuleConfig['wfimagequality'] , $xoopsModuleConfig['updatethumbs']);
                $block['image'] = "thumbs/" . basename($block['image']);
            }
        }
        $block['imagealign'] = $imagealign; 
        // wfsection title
        $ftitle = $myts->makeTboxData4Show(trim($ftitle));
        if (strlen($ftitle) >= $xoopsModuleConfig['wftitlelenght'])
        {
            $ftitle = xoops_substr($ftitle, 0, $xoopsModuleConfig['wftitlelenght'], $trimmarker = '...');
        }

        $block['articletitle'] = spot_removeShouting($ftitle);

        $block['uid'] = $myts->htmlSpecialChars($uidutente);
        $block['author'] = $myts->htmlSpecialChars($fautorevero);

        $xcodes = 1;
        $html = ($fnohtml) ? 0 : 1 ;
        $smiley = ($fnosmiley) ? 0 : 1 ;
        $breaks = ($fnobreaks) ? 1 : 0 ;

        if ($xoopsModuleConfig['wfremimgmain'])
        {
            $fsummary = preg_replace("/(\<img)(.*?)(\>)/si", "", $fsummary);
        }
        $fsummary = $myts->displayTarea(trim($fsummary), $html, $smiley, $xcodes, 1, $breaks);
        $fsummary = preg_replace(array('/[ \t]{2,}/', '/(\n|\r|\r\n){2,}/'), array(' ', ' '), trim($fsummary));
        $block['summary_wfsection'] = trim($fsummary);
        $block['articleid'] = $myts->htmlSpecialChars($fsid);
        $block['rating'] = $myts->htmlSpecialChars($frating);
    }

    if ($xoopsModuleConfig['wfshowmoreart'])
    {
        $block['lang_other_articles'] = _MB_KUHT_OTHER_WFSSTEXT;
        $nsql = "SELECT articleid, title, maintext, summary, changed, published, expired, TRUNCATE(rating,1), nohtml, nosmiley, noxcodes, nobreaks FROM " . $xoopsDB->prefix("wfs_article") . " WHERE (published > 0 AND published <= " . time() . ") AND (expired = 0 OR expired > " . time() . ") AND noshowart = 0 AND offline = 0 AND articleid != " . $fsid . " ORDER BY " . $options[0] . " DESC";
        $nresult = $xoopsDB->query($nsql, $xoopsModuleConfig['wfperpage'], 0);
        $amount = $xoopsDB->getRowsNum($nresult);

        $wfss = array();

        if ($amount >= 1)
        {
            $news['total'] = 1;
            while ($myrow = $xoopsDB->fetchArray($nresult))
            {
                $title = $myts->htmlSpecialChars(trim($myrow["title"]));
                if (strlen($title) >= $xoopsModuleConfig['wftitlelenght'])
                {
                    $title = xoops_substr($title, 0, $xoopsModuleConfig['wftitlelenght'], $trimmarker = '...');
                }
                $wfss['title'] = spot_removeShouting(trim($title));
                $wfss['id'] = $myrow['articleid'];
                if ($options[0] == "published")
                {
                    $wfss['hitsordate'] = formatTimestamp($myrow['published'], "s");
                }elseif ($options[0] == "changed")
                {
                    $wfss['hitsordate'] = formatTimestamp($myrow['changed'], "s");
                }
                else
                {
                    $wfss['hitsordate'] = $myrow['rating'];
                }

                if ($xoopsModuleConfig['wfshowteaser'])
                {
                    $xcodes = ($myrow['noxcodes']) ? 0 : 1 ;
                    $html = ($myrow['nohtml']) ? 0 : 1 ;
                    $smiley = ($myrow['nosmiley']) ? 0 : 1 ;
                    $breaks = ($myrow['nobreaks']) ? 1 : 0 ;

                    $summary = $myts->displayTarea(trim($myrow['summary']), $html, $smiley, $xcodes, 1, $breaks);
                    if ($breaks)
                    {
                        $summary = preg_replace(array('/[ \t]{2,}/', '/(\n|\r|\r\n){2,}/'), array(' ', ' '), trim($summary));
                    }
                    if ($xoopsModuleConfig['wfremimgteas'])
                    {
                        $summary = preg_replace("/(\<img)(.*?)(\>)/si", "", $summary);
                    }
                        if ($xoopsModuleConfig['wftextchars'] > 0)
                        {
                            if (strlen($summary) > $xoopsModuleConfig['wftextchars'])
                            {
                                $summary = xoops_substr($summary, 0, $xoopsModuleConfig['wftextchars'], $trimmarker = '...');
                            }
                        }
                    $wfss['summary'] = trim($summary);
                    $block['textview'] = 1;
                }
                else
                {
                    $block['textview'] = 0;
                } 
                $block['articles'][] = $wfss;
            }
        }
        else
        {
            $wfss['total'] = 0;
        }
    }

    if ($xoopsModuleConfig['wfshowtopicbox'])
    { 
        // rb topic select form for news direct topic access
        $topic_options = '';
        $block['catsel'] = '';
        $sql = "SELECT id, title FROM " . $xoopsDB->prefix("wfs_category") . " order by title ASC";
        if (!$r = $xoopsDB->query($sql))
        {
            exit();
        }
        if ($row = $xoopsDB->fetchArray($r))
        {
            do
            {
                $id = $row['id'];
                $title = $myts->htmlSpecialChars($row['title']);
                if (!XOOPS_USE_MULTIBYTES)
                {
                    if (strlen($title) >= 20)
                    {
                        $title = spot_removeShouting($title);
                        $title = substr($title, 0, 19) . "...";
                    }
                }
                $topic_options .= '<option value="' . $id . '">' . $title . '</option>' . "";
            }
            while ($row = $xoopsDB->fetchArray($r));
        }
        if ($topic_options <> '')
        {
            $block['catsel'] = '<form action="' . XOOPS_URL . '/modules/wfsection/index.php? method="post">' . "";
            $block['catsel'] .= '<select name="storytopic" onchange="submit();">' . "";
            $block['catsel'] .= '<option value="0" selected>' . _MB_KUHT_CHOOSE_WFSS . '</option>' . "";
            $block['catsel'] .= $topic_options . "";
            $block['catsel'] .= '</select></form>' . "";
        } 
        // END rb topic select form for news direct topic access
    } 
    // todo: ministats for wfsections.
    if ($xoopsModuleConfig['wfministats'])
    {
        $block['lang_ministats'] = '<span style="text-transform: uppercase">' . _MB_KUHT_MINISTATS . ':</span>';

        $result = $xoopsDB->query("SELECT count(*) FROM " . $xoopsDB->prefix("wfs_article") . "");
        list($news) = $xoopsDB->fetchRow($result);

        $result = $xoopsDB->query("select sum(counter) FROM " . $xoopsDB->prefix("wfs_article") . "");
        list($storiesviews) = $xoopsDB->fetchRow($result);

        $result = $xoopsDB->query("SELECT TRUNCATE((sum(rating)/" . $news . "),1) FROM " . $xoopsDB->prefix("wfs_article") . "");
        list($rating) = $xoopsDB->fetchRow($result);

        $result = $xoopsDB->query("select sum(votes) FROM " . $xoopsDB->prefix("wfs_article") . "");
        list($votes) = $xoopsDB->fetchRow($result);

        $block['ministats'] = _MB_KUHT_PUBLISHED . ': <b>' . $news . '</b> : ' . "\n";
        $block['ministats'] .= _MB_KUHT_READS . ': <b>' . $storiesviews . '</b> : ' . "\n";
        $block['ministats'] .= _MB_KUHT_WFSSRATING . ': <b>' . $rating . '</b> ' . _MB_KUHT_AVERAGE . "\n";
        $block['ministats'] .= ' <b>' . $votes . '</b> ' . _MB_KUHT_WFSSVOTES . "\n";
    }

    if ($xoopsModuleConfig['wftemplatetype'])
    {
        $block['select_template'] = 1;
    }
    return $block;
}

function b_head_kuht_edit_wfsection($options)
{
    $form .= _MB_KUHT_ORDER . '<select name="options[0]">' . "\n";
    $form .= '<option value="published"';
    if ($options[0] == "published")
    {
        $form .= ' selected="selected"';
    }
    $form .= '>&nbsp;' . _MB_KUHT_CHNG . '</option>' . "\n";
    $form .= '<option value="changed"';
    if ($options[0] == "changed")
    {
        $form .= ' selected="selected"';
    }
    $form .= '>&nbsp;' . _MB_KUHT_DATE . '</option>' . "\n";
    $form .= '<option value="rating"';
    if ($options[0] == "rating")
    {
        $form .= ' selected="selected"';
    }
    $form .= '>&nbsp;' . _MB_KUHT_HITS . '</option>' . "\n";

    $form .= '</select><br />' . "\n";
    return $form;
}

?>
