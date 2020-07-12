<?php
/**
 * $Id: admin_header.php,v 2.0 12 March 2004 catzwolf Exp $
 * Module: Spotlight
 * Version: v2.0
 * Release Date: 12 March 2004
 * Author: Catzwolf
 * Licence: GNU
 */

include("../../../mainfile.php");
include '../../../include/cp_header.php';

include_once(XOOPS_ROOT_PATH . "/class/xoopsmodule.php");
include_once XOOPS_ROOT_PATH . "/class/xoopsmodule.php";
include_once XOOPS_ROOT_PATH . "/modules/spotlight/include/functions.php";
include XOOPS_ROOT_PATH . "/class/xoopstree.php";
include XOOPS_ROOT_PATH . "/class/xoopslists.php";
include XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

if (is_object($xoopsUser))
{
    $xoopsModule = XoopsModule::getByDirname("spotlight");
    if (!$xoopsUser->isAdmin($xoopsModule->mid()))
    {
        redirect_header(XOOPS_URL . "/", 3, _NOPERM);
        exit();
    }
}
else
{
    redirect_header(XOOPS_URL . "/", 1, _NOPERM);
    exit();
}

$myts = &MyTextSanitizer::getInstance();

// Image defines from here
$editimg = "<img src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif ALT="._AM_EDIT.">";
$deleteimg = "<img src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif ALT="._AM_DELETE.">";

?>
