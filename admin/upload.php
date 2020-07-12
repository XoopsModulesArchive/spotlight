<?php
/**
 * $Id: upload.php,v 1.1 2004/01/12 15:40:57 catzwolf Exp $
 * Module: WF-Channel
 * Version: v1.0.5
 * Release Date: 03 Jan 2004
 * Author: Catzwolf
 * Licence: GNU
 */

include("admin_header.php");

$op = '';

if (isset($HTTP_POST_VARS))
{
    foreach ($HTTP_POST_VARS as $k => $v)
    {
        ${$k} = $v;
    }
}

if (isset($HTTP_GET_VARS))
{
    foreach ($HTTP_GET_VARS as $k => $v)
    {
        ${$k} = $v;
    }
}

$rootpath = (isset($HTTP_GET_VARS['rootpath'])) ? intval($HTTP_GET_VARS['rootpath']) : 0;

switch ($op)
{
    case "upload":

        global $HTTP_POST_VARS;

        if ($HTTP_POST_FILES['uploadfile']['name'] != "")
        {
            if (file_exists(XOOPS_ROOT_PATH . "/" . $HTTP_POST_VARS['uploadpath'] . "/" . $HTTP_POST_FILES['uploadfile']['name']))
            {
                redirect_header("upload.php", 1, _AM_CHANIMAGEEXIST);
            }
            $allowed_mimetypes = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png');
            spot_uploading($allowed_mimetypes, $HTTP_POST_FILES['uploadfile']['name'], "upload.php", 0, $HTTP_POST_VARS['uploadpath'], 1);
        }
        else
        {
            redirect_header("upload.php", '2' , _AM_CHANNOIMAGEEXIST);
        }
        exit();
        break;

    case "delfile":

        if (isset($confirm) && $confirm == 1)
        {
            $filetodelete = XOOPS_ROOT_PATH . "/" . $HTTP_POST_VARS['uploadpath'] . "/" . $HTTP_POST_VARS['channelfile'];
            if (file_exists($filetodelete))
            {
                chmod($filetodelete, 0666);
                if (@unlink($filetodelete))
                {
                    redirect_header("upload.php", 3, _AM_FILEDELETED);
                }
                else
                {
                    redirect_header("upload.php", 3, _AM_ERRORDELETEFILE);
                }
            }
            exit();
        }
        else
        {
            xoops_cp_header();
            xoops_confirm(array('op' => 'delfile', 'uploadpath' => $HTTP_POST_VARS['uploadpath'], 'channelfile' => $HTTP_POST_VARS['channelfile'], 'confirm' => 1), 'upload.php', _AM_DELETEFILE . "<br/><br>" . $HTTP_POST_VARS['channelfile'], "Delete");
        }
        break;

    case "default":
    default:

        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

        xoops_cp_header();

        Global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig;

        $dirarray = array(0 => '0', 1 => $xoopsModuleConfig['uploaddir'], 2 => $xoopsModuleConfig['wfuploaddir']);
        $namearray = array(0 => 'Choose Upload Type', 1 => _AM_NEWSIMAGES , 2 => _AM_WFSECTIONIMAGES);
        $listarray = array(0 => '', 1 => _AM_UPLOADCHANLOGO , 2 => _AM_UPLOADLINKIMAGE);
        $displayimage = '';
        $safemode = (ini_get('safe_mode')) ? _AM_ON . _AM_SAFEMODEPROBLEMS: _AM_OFF;
        $downloads = (ini_get('enable_dl')) ? _AM_ON : _AM_OFF;

        spot_adminmenu(_AM_KUHT_NAME_CONF, '');
        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_SERVERSTATUS . "</legend>";
        echo "<div style='padding: 8px;'>";
        echo "<b>" . _AM_SAFEMODE . "</b> " . $safemode . "<br />";
        echo "<b>" . _AM_UPLOADS . "</b> " . $downloads . "<br />";
        if (ini_get('enable_dl'))
        {
            echo "<b>" . _AM_ANDTHEMAX . "</b> " . ini_get('upload_max_filesize') . "<br />";
        }
        echo "</fieldset><br />";

        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_UPLOAD . "</legend>";
        if ($rootpath > 0)
        {
            echo "<div style='padding: 16px 0 0 8px;'><b>" . _AM_UPLOADPATH . "</b> " . XOOPS_ROOT_PATH . "/" . $dirarray[$rootpath] . "</div>";
        }

        $iform = new XoopsThemeForm(_AM_UPLOADIMAGE . $listarray[$rootpath], "op", xoops_getenv('PHP_SELF'));
        $iform->setExtra('enctype="multipart/form-data"');

        ob_start();
        $iform->addElement(new XoopsFormHidden('dir', $rootpath));
        spot_getDirSelectOption($namearray[$rootpath], $dirarray, $namearray, $addnull = 0);
        $iform->addElement(new XoopsFormLabel(_AM_DIRSELECT, ob_get_contents()));
        ob_end_clean();

        if ($rootpath > 0)
        {
            if (!isset($channelfile)) $channelfile = "blank.png";
            $graph_array = &XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/" . $dirarray[$rootpath]);

            $smallimage_select = new XoopsFormSelect('', 'channelfile', $channelfile);
            $smallimage_select->addOptionArray($graph_array);
            $smallimage_select->setExtra("onchange='showImgSelected(\"image\", \"channelfile\", \"" . $dirarray[$rootpath] . "\", \"\", \"" . XOOPS_URL . "\")'");

            $smallimage_tray = new XoopsFormElementTray(_AM_BUTTON, '&nbsp;');
            $smallimage_tray->addElement($smallimage_select);
            $smallimage_tray->addElement(new XoopsFormLabel('', "<br /><br /><img src='" . XOOPS_URL . "/" . $dirarray[$rootpath] . "/" . $channelfile . "' name='image' id='image' alt='' />"));
            $iform->addElement($smallimage_tray);

            $iform->addElement(new XoopsFormFile(_AM_UPLOADLINKIMAGE, 'uploadfile', $xoopsModuleConfig['maxfilesize']));
            $iform->addElement(new XoopsFormHidden('uploadpath', $dirarray[$rootpath]));
            $iform->addElement(new XoopsFormHidden('rootnumber', $rootpath));

            $dup_tray = new XoopsFormElementTray('', '');
            $dup_tray->addElement(new XoopsFormHidden('op', 'upload'));
            $butt_dup = new XoopsFormButton('', '', _SUBMIT, 'submit');
            $butt_dup->setExtra('onclick="this.form.elements.op.value=\'upload\'"');
            $dup_tray->addElement($butt_dup);

            $butt_dupct = new XoopsFormButton('', '', _AM_DELETE, 'submit');
            $butt_dupct->setExtra('onclick="this.form.elements.op.value=\'delfile\'"');
            $dup_tray->addElement($butt_dupct);
            $iform->addElement($dup_tray);
        }
        $iform->display();
        echo "</fieldset>";
}
xoops_cp_footer();

?>