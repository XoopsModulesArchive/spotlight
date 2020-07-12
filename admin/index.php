<?php
/**
 * $Id: index.php, v 2.0 12 March 2004 catzwolf Exp $
 * Module: Spotlight
 * Version: v2.0
 * Release Date: 12 March 2004
 * Author: Catzwolf
 * Orginal Author: Herko (me at herkocoomans dot net) and    
 * 				   Dawilby (willemsen1 at chello dot nl)
 * Licence: GNU
 */

include('admin_header.php');
include_once(XOOPS_ROOT_PATH . '/modules/news/class/class.newsstory.php');
include_once(XOOPS_ROOT_PATH . '/class/xoopsuser.php');
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";

$op = '';

if (isset($_POST))
{
    foreach ($_POST as $k => $v)
    {
        ${$k} = $v;
    } 
} 

if (isset($_GET))
{
    foreach ($_GET as $k => $v)
    {
        ${$k} = $v;
    } 
} 

function displaydetails($image)
{
    echo $image;
} 

function spotlightNewsForm()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $deleteimg, $editimg;

    $idtype = 1;

    $storyarray = NewsStory::getAllPublished(10, 0, 0, 1);

    spot_adminmenu(_AM_KUHT_NAME_NEWS, 0);

    $sql = $xoopsDB->query("SELECT sid, item, auto, image, auto_image, imagealign FROM " . $xoopsDB->prefix("spotlight") . " WHERE sid=1");
    list ($sid, $item, $auto, $indeximage, $auto_image, $imagealign) = $xoopsDB->fetchRow($sql);

    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    $sform = new XoopsThemeForm(_AM_SELECT_NEWS , "op", xoops_getenv('PHP_SELF'));
    $mytree = new XoopsTree($xoopsDB->prefix("stories"), "storyid", "0");
    ob_start();
    $sform->addElement(new XoopsFormHidden('storyid', $item));
    $mytree->makeMySelBox("title", "title", $item, 1);
    $sform->addElement(new XoopsFormLabel(_AM_SELECT_SPOTLIGHT_NEWS, ob_get_contents()));
    ob_end_clean();

    $auto_select = new XoopsFormRadioYN(_AM_SELECT_AUTO_NEWS, 'auto', $auto, ' ' . _YES . '', ' ' . _NO . '');
    $sform->addElement($auto_select);

    if (!isset($imagealign)) $imagealign = "left";
    $imagealign_select = new XoopsFormSelect(_AM_SPOT_IMAGEALIGN, "imagealign", $imagealign);
    $imagealign_select->addOptionArray(array("left" => _AM_SPOT_LEFT, "center" => _AM_SPOT_CENTER, "right" => _AM_SPOT_RIGHT));
    $sform->addElement($imagealign_select);

    if (!$indeximage) $indeximage = "blank.png";

	$graph_array = &XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['uploaddir']);
    $indeximage_select = new XoopsFormSelect('', 'indeximage', $indeximage);
    $indeximage_select->addOptionArray($graph_array);
    $indeximage_select->setExtra("onchange='showImgSelected(\"image1\", \"indeximage\", \"" . $xoopsModuleConfig['uploaddir'] . "\", \"\", \"" . XOOPS_URL . "\")'");
    $indeximage_tray = new XoopsFormElementTray(_AM_SELECT_IMG, '&nbsp;');
    $indeximage_tray->addElement($indeximage_select);
    $indeximage_tray->addElement(new XoopsFormLabel('', "<p><img src='" . XOOPS_URL . "/" . $xoopsModuleConfig['uploaddir'] . "/" . $indeximage . "' name='image1' id='image1' alt='' height ='200' width ='200'/></p>" ._AM_NOTERESIZE . ""));
    $sform->addElement($indeximage_tray);

    $autoimage_select = new XoopsFormRadioYN(_AM_SELECT_NEWS_AUTO_IMG, 'auto_image', $auto_image, ' ' . _YES . '', ' ' . _NO . '');
    $sform->addElement($autoimage_select); 
    $sform->addElement(new XoopsFormHidden('idtype', 1));

    $button_tray = new XoopsFormElementTray('', '');
    $hidden = new XoopsFormHidden('op', 'submit');
    $button_tray->addElement($hidden);
    $butt_dup = new XoopsFormButton('', '', _AM_SUBMIT, 'submit');
    $butt_dup->setExtra('onclick="this.form.elements.op.value=\'submit\'"');
    $button_tray->addElement($butt_dup);
    $butt_dupct = new XoopsFormButton('', '', _CANCEL, 'submit');
    $butt_dupct->setExtra('onclick="this.form.elements.op.value=\'default\'"');
    $button_tray->addElement($butt_dupct);
    $sform->addElement($button_tray);
    $sform->display();

    echo "<h4>" . _AM_LAST10NEWARTS . "</h4>";
    echo "<table class='outer' cellspacing='1' cellpadding = '2' width='100%'>";
    echo "<tr>";
    echo "<td class='bg3' align='center'><b>" . _AM_STORYID . "</b></td>";
    echo "<td class='bg3' align='left'><b>" . _AM_TITLE . "</b></td>";
    echo "<td class='bg3' align='center'><b>" . _AM_TOPIC . "</b></td>";
    echo "<td class='bg3' align='center'><b>" . _AM_POSTER . "</b></td>";
    echo "<td class='bg3' align='center'><b>" . _AM_PUBLISHED . "</b></td>";
    echo "<td class='bg3' align='center'><b>" . _AM_ACTION . "</b></td>";
    echo "</tr>";

    foreach ($storyarray as $eachstory)
    {
        $published = formatTimestamp($eachstory->published());
        $topic = $eachstory->topic();
        echo "<tr>";
        echo "<td class='head' align='center'><b>" . $eachstory->storyid() . "</b></td>";
        echo "<td class='even' align='left'><a href=" . XOOPS_URL . "/modules/news/article.php?storyid=" . $eachstory->storyid() . ">" . $eachstory->title() . "</a></td>";
        echo "<td class='odd' align='center'>" . $topic->topic_title() . "</td>";
        echo "<td class='even' align='center'><a href=" . XOOPS_URL . "/userinfo.php?uid=" . $eachstory->uid() . ">" . $eachstory->uname() . "</a></td>";
        echo "<td class='odd' align='center'>" . $published . "</td>";
        echo "<td class='even' align='center'><a href='" . XOOPS_URL . "/modules/news/admin/index.php?op=edit&amp;storyid=" . $eachstory->storyid() . "'>$editimg</a>";
        echo "<a href='" . XOOPS_URL . "/modules/news/admin/index.php?op=delete&amp;storyid=" . $eachstory->storyid() . "'>$deleteimg</a></td>";
        echo "</tr>";
    } 
    echo "</table><br />";
} 

function spotlightWFSectionForm()
{
    global $xoopsDB, $xoopsUser, $xoopsConfig, $xoopsModuleConfig, $deleteimg, $editimg;

    spot_adminmenu(_AM_KUHT_NAME_WFSS, 0);

    $sql3 = ("SELECT item, auto, image, auto_image, imagealign FROM " . $xoopsDB->prefix("spotlight") . " WHERE sid=2;");
    $result3 = $xoopsDB->query($sql3, 0, 1);
    list ($item, $auto, $indeximage, $auto_image, $imagealign) = $xoopsDB->fetchRow($result3);

    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    $sform = new XoopsThemeForm(_AM_SELECT_WFS , "op", xoops_getenv('PHP_SELF'));
    $sform->setExtra('enctype="multipart/form-data"');
    $mytree = new XoopsTree($xoopsDB->prefix("wfs_article"), "articleid", "0");

    ob_start();
    $sform->addElement(new XoopsFormHidden('articleid', $item));
    $mytree->makeMySelBox("title", "title", $item, 1);
    $sform->addElement(new XoopsFormLabel(_AM_SELECT_SPOTLIGHT_WFS, ob_get_contents()));
    ob_end_clean();

    $auto_select = new XoopsFormRadioYN(_AM_SELECT_AUTO_WFS, 'auto', $auto, ' ' . _YES . '', ' ' . _NO . '');
    $sform->addElement($auto_select);

    if (!isset($imagealign)) $imagealign = "left";
    $imagealign_select = new XoopsFormSelect(_AM_SPOT_IMAGEALIGN, "imagealign", $imagealign);
    $imagealign_select->addOptionArray(array("left" => _AM_SPOT_LEFT, "center" => _AM_SPOT_CENTER, "right" => _AM_SPOT_RIGHT));
    $sform->addElement($imagealign_select);

    if (!$indeximage) $indeximage = "blank.png";
    $graph_array = &XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['wfuploaddir']);
    $indeximage_select = new XoopsFormSelect('', 'indeximage', $indeximage);
    $indeximage_select->addOptionArray($graph_array);
    $indeximage_select->setExtra("onchange='showImgSelected(\"image1\", \"indeximage\", \"" . $xoopsModuleConfig['wfuploaddir'] . "\", \"\", \"" . XOOPS_URL . "\")';)"); 
    // $indeximage_select -> setExtra("onchange='displaydetails($indeximage)';)");
    $indeximage_tray = new XoopsFormElementTray(_AM_SELECT_IMG_WFS, '&nbsp;');
    $indeximage_tray->addElement($indeximage_select);
    $indeximage_tray->addElement(new XoopsFormLabel('', "<p><img src='" . XOOPS_URL . "/" . $xoopsModuleConfig['wfuploaddir'] . "/" . $indeximage . "' name='image1' id='image1' alt='' height='200' width='200' border = '1'/></p>Image has been resized"));
    $sform->addElement($indeximage_tray);

    $autoimage_select = new XoopsFormRadioYN(_AM_SELECT_WFS_AUTO_IMG, 'auto_image', $auto_image, ' ' . _YES . '', ' ' . _NO . '');
    $sform->addElement($autoimage_select); 
    // $sform -> addElement(new XoopsFormFile(_AM_SELECT_UPLOADCHANLOGO, 'spotimage', $xoopsModuleConfig['maxfilesize']), false);
    $sform->addElement(new XoopsFormHidden('idtype', 2));

    $button_tray = new XoopsFormElementTray('', '');
    $hidden = new XoopsFormHidden('op', 'submitWFSection');
    $button_tray->addElement($hidden);
    $butt_dup = new XoopsFormButton('', '', _AM_SUBMIT, 'submit');
    $butt_dup->setExtra('onclick="this.form.elements.op.value=\'submit\'"');
    $button_tray->addElement($butt_dup);
    $butt_dupct = new XoopsFormButton('', '', _CANCEL, 'submit');
    $butt_dupct->setExtra('onclick="this.form.elements.op.value=\'default\'"');
    $button_tray->addElement($butt_dupct);
    $sform->addElement($button_tray);
    $sform->display();

    echo "<h4>" . _AM_LAST10WFSARTS . "</h4>";

    echo "<table class='outer' cellspacing='1' width='100%'>";
    echo "<tr>";
    echo "<td class='bg3' align='center'><b>" . _AM_STORYID . "</b></td>";
    echo "<td class='bg3' align='left'><b>" . _AM_TITLE . "</b></td>";
    echo "<td class='bg3' align='center'><b>" . _AM_CATEGORYT . "</b></td>";
    echo "<td class='bg3' align='center'><b>" . _AM_POSTER . "</b></td>";
    echo "<td class='bg3' align='center'><b>" . _AM_PUBLISHED . "</b></td>";
    echo "<td class='bg3' align='center'><b>" . _AM_CHANGED . "</b></td>";
    echo "<td class='bg3' align='center'><b>" . _AM_WEIGHT . "</b></td>";
    echo "<td class='bg3' align='center'><b>" . _AM_ACTION . "</b></td>";
    echo "</tr>";

    $sql = ("SELECT articleid, title, categoryid, uid, changed, weight, published FROM " . $xoopsDB->prefix("wfs_article") . " WHERE changed < " . time() . " AND published > 0 AND (expired = 0 OR expired > " . time() . ") ORDER BY articleid DESC;");
    $result = $xoopsDB->query($sql, 0, 10);
    if (!$result)
    {
        echo '<tr ><td align="center" colspan ="8" class="head"><b>' . _AM_NOTFOUND . '</b></td></tr>';
    } 
    else
    {
        while (list ($articleid, $title, $catid, $uid, $changed, $weight, $published) = $xoopsDB->fetchRow($result))
        {
            echo "<tr>";
            echo "<td align='center' class='head'><b>" . $articleid . "</b></td>";
            echo "<td align='left' class='even'><a href='".XOOPS_URL."/modules/wfsection/article.php?articleid=" . $articleid . "'>" . $title . "</a></td>";
            $sql2 = ("SELECT title FROM " . $xoopsDB->prefix("wfs_category") . " WHERE id=" . $catid . ";");
            $result2 = $xoopsDB->query($sql2, 0, 1);
            while (list ($title) = $xoopsDB->fetchRow($result2))
            {
                echo '<td align="center" class="odd" nowrap:>' . $title . '</td>' . "\n";
            } 
            $uname = XoopsUser::getUnameFromId($uid);
            echo "<td align='center' class='even'><a href='/userinfo.php?uid=" . $uid . "'>" . $uname . "</a></td>";
            echo "<td align='center' class='odd'>" . formatTimestamp($published, "m") . "</td>";
            echo "<td align='center' class='even'>" . formatTimestamp($changed, "m") . "</td>";
            echo "<td align='center' class='odd'>" . $weight . "</td>";
            echo "<td align='center' class='even'><a href=".XOOPS_URL."/modules/wfsection/admin/index.php?op=edit&articleid=" . $articleid . ">$editimg</a>";
            echo "<a href=".XOOPS_URL."/modules/wfsection/admin/index.php?op=delete&articleid=" . $articleid . ">$deleteimg</a></td>";
            echo "</tr>";
        } 
    } 
    echo "</table><br />";
} 

switch ($op)
{
    case 'submit':

        global $xoopsDB, $xoopsModuleConfig;

        //$idtype = addslashes($_POST["idtype"]);

        $item = (isset($_POST["storyid"])) ? addslashes($_POST["storyid"]) : addslashes($_POST["articleid"]);
        $auto = addslashes($_POST["auto"]);
        $auto_image = addslashes($_POST["auto_image"]);
        $auto = (isset($auto)) ? $auto: 0;
        $auto_image = (isset($auto_image)) ? $auto_image : 0;
        $imagealign = addslashes($_POST["imagealign"]);

        $image = ($_POST["indeximage"] != "blank.png") ? $myts->makeTboxData4Save($_POST["indeximage"]) : '';

        $sql = sprintf("UPDATE " . $xoopsDB->prefix("spotlight") . " SET item='" . $item . "', auto='" . $auto . "', image='" . $image . "', auto_image='" . $auto_image . "', imagealign='" . $imagealign . "' WHERE sid = $idtype");
        $result = $xoopsDB->query($sql);
        $error = "Error while updating Spotlight Block Data: <br /><br />" . $sql;
        if (!$result)
        {
            trigger_error($error, E_USER_ERROR);
        } 
        redirect_header("index.php", 1 , _AM_MESSAGE);
        exit();
        break;

    case 'news':

        xoops_cp_header();

        $sql = "SELECT dirname FROM " . $xoopsDB->prefix("newblocks") . " WHERE dirname = 'news';"; 
        // uncertain check if WF-Sections is installed or not.
        $result = $xoopsDB->query($sql);

        if (!$row = $xoopsDB->fetchRow($result))
        {
            exit('The News Module is not installed on your system.');
        } 
        else
        {
            spotlightNewsForm();
        } 

        break;

    case 'wfsections':

        global $xoopsDB;

        xoops_cp_header();
        $sql = "SELECT dirname FROM " . $xoopsDB->prefix("newblocks") . " WHERE dirname = 'wfsection';"; 
        // uncertain check if WF-Sections is installed or not.
        $result = $xoopsDB->query($sql);

        if (!$row = $xoopsDB->fetchRow($result))
        {
            exit('The WF-Section Module is not installed on your system.');
        } 
        else
        {
            spotlightWFSectionForm();
        } 
        break;

    case 'start':
    default:
        xoops_cp_header();
        spot_adminmenu(_AM_KUHT_NAME_CONF);
        break;
} 
xoops_cp_footer();

?>