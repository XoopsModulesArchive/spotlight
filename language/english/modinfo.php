<?php
/**
 * $Id: modinfo.php, v 2.0 12 March 2004 catzwolf Exp $
 * Module: Spotlight
 * Version: v2.0
 * Release Date: 12 March 2004
 * Author: Catzwolf
 * Orginal Author: Herko (me at herkocoomans dot net) and    
 * 				   Dawilby (willemsen1 at chello dot nl)
 * Licence: GNU
 */

// The name of this module
define('_MI_KUHT_NAME',' Spotlight');

// A brief description of this module
define('_MI_KUHT_DESC',' Puts a news item in a central spotlight block.');

// Names of blocks for this module (Not all module has blocks)
define('_MI_KUHT_BNAME','Spotlight - News');
define('_MI_KUHT_BNAME1','Spotlight - WF-Sections');

// Names of admin menu items
define('_MI_KUHT_ADMENU1','General Configuration');
define('_MI_KUHT_ADMENU2','News Block');
define('_MI_KUHT_ADMENU3','WF-Section Block');

define('_MI_KUHT_UPLOADDIR','News Image Upload Directory (No trailing slash)');
define('_MI_KUHT_WFUPLOADDIR','WF-Section Image Upload Directory (No trailing slash)');
define('_MI_KUHT_LINKIMAGES','Spotlight Image Upload Directory (No trailing slash)');
define('_MI_KUHT_MAXFILESIZE','Maximum upload size');
define('_MI_KUHT_IMGWIDTH','Maximum upload Image width');
define('_MI_KUHT_IMGHEIGHT','Maximum upload Image height');
define('_MI_KUHT_UPDATETHUMBS','Always update thumbs?');

define('_MI_KUHT_NEWSSHOWTHUMBS','Use Thumbnail for News Image?');
define('_MI_KUHT_DIMGWIDTH','News Image Display width');
define('_MI_KUHT_DIMGHEIGHT','News Image Display height');
define('_MI_KUHT_RETAINIMGSIZE','Use News image Actual size?');
define('_MI_KUHT_PERPAGE', 'Maximum number of articles to be displayed?');
define('_MI_KUHT_MORE_LINKS','Show other news list?');
define('_MI_KUHT_TITLECHARS','Length of spotlight News title');
define('_MI_KUHT_DISP','Number of News to Display');
define('_MI_KUHT_TOPICS','Show News topic select box?'); // By Romu R&B.
define('_MI_KUHT_TEXTVIEW', 'Show News teaser?');
define('_MI_KUHT_INCSTATS','Include News mini-stats line?');
define('_MI_KUHT_HOMETEXTCHARS', 'Length of Spotlight News teaser');
define('_MI_KUHT_HOMETEXTDSC','In number of letters. 0 = Full Text. (Only affects Non-Html Stories)');
define('_MI_KUHT_CHOOSETEMPLATE','Choose two column News template?');
define('_MI_KUHT_CHOOSETEMPLATEDESC','A stacked News template will be used if no is selected');
define('_MI_KUHT_ORDER','News Story Display Order');
define('_MI_KUHT_QUALITY','News Image Quality');
define('_MI_KUHT_STOPSHOUTING','Stop Shouting in Titles');
define('_MI_KUHT_REMIMGMAIN','Remove Images from Main Spotlight News Story?');
define('_MI_KUHT_REMIMGTEAS','Remove Images from News Teasers?');

define('_MI_KUHT_WFSSHOWTHUMBS','Use Thumbnail for WF-Section Image?');
define('_MI_KUHT_WFDIMGWIDTH','WF-Section Image Display width');
define('_MI_KUHT_WFDIMGHEIGHT','WF-Section Image Display height');
define('_MI_KUHT_WFRETAINIMGSIZE','Use WF-Section image Actual size?');
define('_MI_KUHT_WFPERPAGE', 'Maximum number of articles to be displayed?');
define('_MI_KUHT_WFMORE_LINKS','Show other WF-Section list?');
define('_MI_KUHT_WFTITLECHARS','Length of spotlight WF-Section title');
define('_MI_KUHT_WFDISP','Number of WF-Section articles to Display');
define('_MI_KUHT_WFTOPICS','Show WF-Section topic select box?'); // By Romu R&B.
define('_MI_KUHT_WFTEXTVIEW', 'Show WF-Section teaser?');
define('_MI_KUHT_WFINCSTATS','Include WF-Section mini-stats line?');
define('_MI_KUHT_WFHOMETEXTCHARS', 'Length of Spotlight WF-Section teaser');
define('_MI_KUHT_WFHOMETEXTDSC','In number of letters. 0 = Full Text. (Only affects Non-Html Articles)');
define('_MI_KUHT_WFCHOOSETEMPLATE','Choose two column WF-Section template?');
define('_MI_KUHT_WFCHOOSETEMPLATEDESC','A stacked WF-Section template will be used if no is selected');
define('_MI_KUHT_WFORDER','WF-Section Article Display Order');
define('_MI_KUHT_WFQUALITY','WF-Section Image Quality');
define('_MI_KUHT_WFREMIMGMAIN','Remove Images from Main WF-Section Article?');
define('_MI_KUHT_WFREMIMGTEAS','Remove Images from WF-Section Article Teasers?');

?>
