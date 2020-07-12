<?php
/**
 * $Id: functions.php, v 2.0 12 March 2004 catzwolf Exp $
 * Module: Spotlight
 * Version: v2.0
 * Release Date: 12 March 2004
 * Author: Catzwolf
 * Orginal Author: Herko (me at herkocoomans dot net) and    
 * 				   Dawilby (willemsen1 at chello dot nl)
 * Licence: GNU
 */

/**
 * spot_htmlarray()
 * 
 * @param $thishtmlpage
 * @param $thepath
 * @return 
 **/
function spot_htmlarray($thishtmlpage, $thepath)
{
    global $xoopsConfig, $wfsConfig;

    $file_array = filesarray($thepath);

    echo "<select size='1' name='htmlfile'>";
    echo "<option value='-1'>---------------------</option>";
    foreach($file_array as $htmlpage)
    {
        if ($htmlpage == $thishtmlpage)
        {
            $opt_selected = "selected='selected'";
        } 
        else
        {
            $opt_selected = "";
        } 
        echo "<option value='" . $htmlpage . "' $opt_selected>" . $htmlpage . "</option>";
    } 
    echo "</select>";
    return $htmlpage;
} 

/**
 * spot_filesarray()
 * 
 * @param $filearray
 * @return 
 **/
function spot_filesarray($filearray)
{
    $files = array();
    $dir = opendir($filearray);

    while (($file = readdir($dir)) !== false)
    {
        if ((!preg_match("/^[.]{1,2}$/", $file) && preg_match("/[.htm|.html|.xhtml]$/i", $file) && !is_dir($file)))
        {
            if (strtolower($file) != 'cvs' && !is_dir($file))
            {
                $files[$file] = $file;
            } 
        } 
    } 
    closedir($dir);
    asort($files);
    reset($files);
    return $files;
} 



/**
 * spot_getDirSelectOption()
 * 
 * @param $selected
 * @param $dirarray
 * @param $namearray
 * @return 
 **/
function spot_getDirSelectOption($selected, $dirarray, $namearray, $addnull = 0)
{ 
    // global $workd;
    echo "<select size='1' name='workd' onchange='location.href=\"upload.php?rootpath=\"+this.options[this.selectedIndex].value'>";
    if ($addnull == 1)
    {
        echo "<option value=''>--------------------------------------</option>";
    } 
    foreach($namearray as $namearray => $workd)
    {
        if ($workd === $selected)
        {
            $opt_selected = "selected";
        } 
        else
        {
            $opt_selected = "";
        } 
        echo "<option value='" . htmlspecialchars($namearray, ENT_QUOTES) . "' $opt_selected>" . $workd . "</option>";
    } 
    echo "</select>";
} 

function spot_uploading($allowed_mimetypes, $httppostfiles, $redirecturl = "index.php", $num = 0, $dir = "uploads", $redirect = 0)
{
    include_once XOOPS_ROOT_PATH . "/class/uploader.php";

    global $xoopsConfig, $xoopsModuleConfig, $HTTP_POST_VARS;

    $maxfilesize = $xoopsModuleConfig['maxfilesize'];
    $maxfilewidth = $xoopsModuleConfig['maximgwidth'];
    $maxfileheight = $xoopsModuleConfig['maximgheight'];
    $uploaddir = XOOPS_ROOT_PATH . "/" . $dir . "/";

    $uploader = new XoopsMediaUploader($uploaddir, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);

    if ($uploader->fetchMedia($HTTP_POST_VARS['xoops_upload_file'][$num]))
    {
        if (!$uploader->upload())
        {
            $errors = $uploader->getErrors();
            redirect_header($redirecturl, 1, $errors);
        } 
        else
        {
            if ($redirect)
            {
                redirect_header($redirecturl, 1 , _AM_FILEUPLOADED);
            } 
        } 
    } 
    else
    {
        $errors = $uploader->getErrors();
        redirect_header($redirecturl, 1, $errors);
    } 
}


/**
 * adminmenu()
 * 
 * @param string $header optional : You can gice the menu a nice header
 * @param string $extra optional : You can gice the menu a nice footer
 * @param array $menu required : This is an array of links. U can
 * @param int $scount required : This will difine the amount of cells long the menu will have.  
 * NB: using a value of 3 at the moment will break the menu where the cell colours will be off display.
 * @return THIS ONE WORKS CORRECTLY
 */
function spot_adminmenu($header = '', $extra = '', $menu = '', $scount = 4)
{
    global $xoopsConfig, $xoopsModule;

    if (empty($menu))
    {
        /**
         * You can change this part to suit your own module. Defining this here will save you form having to do this each time.
         */

        $menu = array(
            _AM_KUHT_NAME_CONFIG => "" . XOOPS_URL . "/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid') . "",
            _AM_KUHT_NAME_NEWSBLOCK => "index.php?op=news",
            _AM_KUHT_NAME_MINI => "mini.php",
            _AM_KUHT_NAME_XML => "xml.php",
            _AM_KUHT_NAME_WFSSBLOCK => "index.php?op=wfsections",
            _AM_KUHT_NAME_UPLOAD => "upload.php",
            );
    } 

    $oddnum = array(1 => "1", 3 => "3", 5 => "5", 7 => "7", 9 => "9", 11 => "11", 13 => "13");

    /**
     * the amount of cells per menu row
     */
    $count = 0;
    /**
     * Set up the first class
     */
    $class = "even";
    /**
     * Sets up the width of each menu cell
     */

    echo "<h3>" . $header . "</h3>";
    echo "<table width = '100%' cellpadding= '2' cellspacing= '1' class='outer'><tr>";

    /**
     * Check to see if $menu is and array
     */
    if (is_array($menu))
    {
        foreach ($menu as $menutitle => $menulink)
        {
            $count++;
            $width = 100 / $scount;
            $width = round($width);
            /**
             * Menu table begin
             */
            echo "<td class='$class' align='center' valign='middle' width= $width%>";
            echo "<a href='" . $menulink . "'>" . $menutitle . "</a></td>";

            /**
             * Break menu cells to start a new row if $count > $scount
             */
            if ($count >= $scount)
            {
                /**
                 * If $class is the same for the end and start cells, invert $class
                 */
                $class = ($class == 'odd' && in_array($count, $oddnum)) ? "even" : "odd";
                echo "</tr>";
                $count = 0;
            } 
            else
            {
                $class = ($class == 'even') ? "odd" : "even";
            } 
        } 
        /**
         * checks to see if there are enough cell to fill menu row, if not add empty cells
         */
        if ($count >= 1)
        {
            $counter = 0;
            while ($counter < $scount - $count)
            {
                echo '<td class="' . $class . '">&nbsp;</td>';
                $class = ($class == 'even') ? 'odd' : 'even';
                $counter++;
            } 
        } 
        echo "</table><br />";
    } 
    if ($extra)
    {
        echo "<div>$extra</div>";
    } 
} 


function checkSpotAccess($grps, $time = -1, $message = '')
{
    global $xoopsUser, $xoopsModule;

    $groupid = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);

    $grps = explode(" ", $grps);

    foreach ($groupid as $group)
    {
        if (in_array($group, $grps))
            return 1;
        else
        if ($time != -1)
        {
            redirect_header('javascript:history.back(1);', $time, $message);
            exit();
        } 
        else
        {
            return 0;
        } 
    } 
    return 0;
} 

/**
 * Function createthumb($name,$filename,$new_w,$new_h)
 * creates a resized image
 * variables:
 * $name		Original filename
 * $filename	Filename of the resized image
 * $new_w		width of resized image
 * $new_h		height of resized image
 */
function spot_createthumb($name, $root, $path, $savepath, $new_w = 100, $new_h = 100, $quality = 90, $update = 0, $aspect = 0)
{ 
    global $xoopsModuleConfig; 
    // Try to increase server memory. Not all servers will allow you to do this.
    //ini_set ("memory_limit", "50M");
    // echo $quality;
    $savefile = $path . $savepath . $new_w . "x" . $new_h . "_" . $name;
    $savepath = $root . $savefile;
    $temp_savepath = $savepath;
    /**
     * Get image location
     */
    $image_path = $root . $path . $name;
    $ext = end(explode('.', $image_path));

    /**
     * echo "get orginal image path: ".$image_path."<br />";
     */
    if ($update == 0 && file_exists($savepath))
    {
        return $savepath;
    }
    else
    {
        if (file_exists($savepath))
        {
            @unlink($savepath);
        }
        $img = '';

        if ($ext == 'jpg' || $ext == 'jpeg')
        {
            $img = @imagecreatefromjpeg($image_path);
        }
        else if ($ext == 'png')
        {
            $img = @imagecreatefrompng($image_path); 
            // Only if your version of GD includes GIF support
        }
        else if ($ext == 'gif')
        { 
            // Only if your version of GD includes GIF support
            if (function_exists('imagecreatefromgif'))
            {
                $img = @imagecreatefromgif($image_path);
            }
        } 
        // If an image was successfully loaded, test the image for size
        if ($img)
        { 
            // Get image size and scale ratio
            list($width, $height, $type, $attr) = getimagesize($image_path); 
            // if (!$xoopsModuleConfig['keepaspect']){
            $scale = min($new_w / $width, $new_h / $height); 
            // } else {
            // $scale = min($new_w, $new_h);
            // }
            // If the image is larger than the max shrink it
            if ($scale < 1)
            {
                if ($aspect == 1)
                {
                    $new_width = floor($scale * $width);
                    $new_height = floor($scale * $height);
                }
                else
                {
                    $new_width = floor($new_w);
                    $new_height = floor($new_h);
                } 
                // Create a new temporary image
                if (function_exists('imagecreatetruecolor'))
                {
                    $tmp_img = imagecreatetruecolor($new_width, $new_height);
                }
                else
                {
                    $tmp_img = imagecreate($new_width, $new_height);
                } 
                // Copy and resize old image into new image
                ImageCopyResampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagedestroy($img);
                flush();
                $img = $tmp_img;
            }
        } 
        // Create error image if necessary
        if (!$img)
        {
            $img = imagecreate($new_w, $new_h);
            $center_h = $new_w / 2-9;
            $center_w = $new_w / 5;
            imagecolorallocate($img, 255, 255, 255);
            $c = imagecolorallocate($img, 70, 70, 70);
            imageline($img, 0, 0, $new_w, $new_h, $c);
            imageline($img, $new_w, 0, 0, $new_h, $c);
            imagestring ($img, 4, $center_w, $center_h, "Image", $c);
        }
        if ($ext == "jpeg" || $ext == "jpg" || $ext == "gif")
        {
            imagejpeg ($img, $savepath, $quality);
        }elseif ($ext == "png")
        {
            imagepng($img, $savepath);
        }
        else
        {
            imagejpeg ($img, $savepath, $quality);
        }
        imagedestroy($img);
        flush();
        return $savefile;
    }
    // echo "File link is ".$savefile;
} 

function spot_cleanvars($string)
{ 
    // I may have got this wrong, will do more testing later.
    $string = str_replace("-", " - ", $string);
    $string = str_replace(".", ". ", $string);
    $string = str_replace(",", ", ", $string);
    $string = str_replace(" ,", ", ", $string);
    $string = str_replace("!", "! ", $string);
    $string = str_replace("?", "? ", $string);
    $string = str_replace(":", ": ", $string);
    $string = str_replace(";", "; ", $string);
    $string = str_replace("(", "( ", $string); 
    // Remove multiple spaces/tabs
    $string = str_replace ("\"", "", $string);
    $string = str_replace ("'", "", $string); 
    // $string = preg_replace('/[ \t]{2,}/', ' ', $string);
    // $string = preg_replace('/"/',"",$string);
    // Remove multipule lines
    // $string = preg_replace('/(\n|\r|\r\n){2,}/', '\r', $string);
    // $string = preg_replace(array('/[ \t]{2,}/', '/(\n|\r|\r\n){2,}/'), array('/ /', '\r'), $string);
    return trim($string);
} 

function spot_removeShouting($string)
{
    global $xoopsModuleConfig; 

    if (isset($xoopsModuleConfig['stopshouting']))
    {
        return $string;
    } 

    // $lower_exceptions = array("to" => "1", "a" => "1", "the" => "1", "of" => "1"
    $lower_exceptions = array("to" => "1", "of" => "1", "WF" => "1"
        );

    $higher_exceptions = array("I" => "1", "II" => "1", "III" => "1", "IV" => "1",
        "V" => "1", "VI" => "1", "VII" => "1", "VIII" => "1",
        "XI" => "1", "X" => "1", "I™" => "1", "II™" => "1", "III™" => "1", "IV™" => "1",
        "V™" => "1", "VI™" => "1", "VII™" => "1", "VIII™" => "1",
        "XI™" => "1", "X™" => "1", "I:" => "1", "II:" => "1", "III:" => "1", "IV:" => "1",
        "V:" => "1", "VI:" => "1", "VII:" => "1", "VIII:" => "1",
        "XI:" => "1", "X:" => "1"
        );

    $string = spot_cleanvars($string);

    $words = split(" ", $string);
    $newwords = array();
    foreach ($words as $word)
    {
        if (!in_array($word, $higher_exceptions)) $word = strtolower($word);
        if (!in_array($word, $lower_exceptions))$word[0] = strtoupper($word[0]);
        array_push($newwords, $word);
    } 
    $text = join(" ", $newwords);

    $text = str_replace(" - ", "-", $text);
    $text = str_replace("( ", "(", $text);
    $text = str_replace(". ", ".", $text);
    $text = str_replace ("Array", "", $text);
    $text = preg_replace('/[ \t]{2,}/', ' ', $text);

    return $text;
} 

function spot_summarize($string, $limit = 10)
{
    if (empty($string)) return ''; 
    // spot_cleanvars($string);
    $tok = strtok($string, " ");
    $words = 0;
    $text = '';
    while ($tok)
    {
        $text .= " $tok";
        if (($words >= $limit) && ((substr($tok, -1) == "!") || (substr($tok, -1) == ".") || (substr($tok, -1) == " ")))
        {
            return trim($text);
            unset($text);
        } 
        $tok = strtok(" ");
        $words++;
    } 
    return trim($text);
} 

?>