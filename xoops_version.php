<?php
// ------------------------------------------------------------------------- //
//                XOOPS - PHP Content Management System                      //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //
//                                                                           //
//                               "Spotlight"                                 //
//                                                                           //
//               http://linux.kuht.it  - http://www.kuht.it                  //
//                                                                           //
//                              spark@kuht.it                                //
//                                                                           //
//              Adapted for XOOPS 2.0 by Herko and dAWiLbY                   // 
//              Features modified by Vinit                                   //
//---------------------------------------------------------------------------//
$modversion['name'] = _MI_KUHT_NAME;
$modversion['version'] = 2.2; 
$modversion['description'] = _MI_KUHT_DESC;
$modversion['author'] = 'Spark [ kuht.it ]<br />Adapted for XOOPS 2.0<br />by<br />Herko, dAWiLbY and Catzwolf<br /> Features modified by Vinit';
$modversion['credits'] = 'http://linux.kuht.it';
$modversion['help'] = 'spark@kuht.it';
$modversion['license'] = 'GPL see LICENSE';
$modversion['official'] = 0;
$modversion['image'] = 'images/kuht_slogo.png';
$modversion['dirname'] = 'spotlight';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php?op=news';
$modversion['adminmenu'] = 'admin/menu.php';

// Blocks
$modversion['blocks'][1]['file'] = 'kuht_head_news.php';
$modversion['blocks'][1]['name'] = _MI_KUHT_BNAME;
$modversion['blocks'][1]['description'] = 'Spotlight - Focus News';
$modversion['blocks'][1]['show_func'] = 'b_head_kuht_show_news';
$modversion['blocks'][1]['edit_func'] = 'b_head_kuht_edit_news';
$modversion['blocks'][1]['options'] = 'published';
$modversion['blocks'][1]['template'] = 'news_block_spotlight.html';

$modversion['blocks'][2]['file'] = 'kuht_head_wfsection.php';
$modversion['blocks'][2]['name'] = _MI_KUHT_BNAME1;
$modversion['blocks'][2]['description'] = 'Spotlight - Focus WF-Section';
$modversion['blocks'][2]['show_func'] = 'b_head_kuht_show_wfsection';
$modversion['blocks'][2]['edit_func'] = 'b_head_kuht_edit_wfsection';
$modversion['blocks'][2]['options'] = 'published';
$modversion['blocks'][2]['template'] = 'wfsections_block_spotlight.html';

// Database
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0] = 'spotlight';
$modversion['tables'][1] = 'spotlight_mini';
$modversion['tables'][2] = 'spotlight_xml';

// Menu
$modversion['hasMain'] = 0;

//Module Configuration

$modversion['config'][1]['name'] = 'stopshouting';
$modversion['config'][1]['title'] = '_MI_KUHT_STOPSHOUTING';
$modversion['config'][1]['description'] = '';
$modversion['config'][1]['formtype'] = 'yesno';
$modversion['config'][1]['valuetype'] = 'int';
$modversion['config'][1]['default'] = 0;

$modversion['config'][37]['name'] = 'uploaddir';
$modversion['config'][37]['title'] = '_MI_KUHT_UPLOADDIR';
$modversion['config'][37]['description'] = '_MI_KUHT_UPLOADDIRDSC';
$modversion['config'][37]['formtype'] = 'textbox';
$modversion['config'][37]['valuetype'] = 'text';
$modversion['config'][37]['default'] = 'modules/news/images';

$modversion['config'][2]['name'] = 'wfuploaddir';
$modversion['config'][2]['title'] = '_MI_KUHT_WFUPLOADDIR';
$modversion['config'][2]['description'] = '_MI_KUHT_WFUPLOADDIRDSC';
$modversion['config'][2]['formtype'] = 'textbox';
$modversion['config'][2]['valuetype'] = 'text';
$modversion['config'][2]['default'] = 'modules/wfsection/images/article';

$modversion['config'][3]['name'] = 'maxfilesize';
$modversion['config'][3]['title'] = '_MI_KUHT_MAXFILESIZE';
$modversion['config'][3]['description'] = '_MI_KUHT_MAXFILESIZEDSC';
$modversion['config'][3]['formtype'] = 'textbox';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = 50000;

$modversion['config'][4]['name'] = 'maximgwidth';
$modversion['config'][4]['title'] = '_MI_KUHT_IMGWIDTH';
$modversion['config'][4]['description'] = '_MI_KUHT_IMGWIDTHDSC';
$modversion['config'][4]['formtype'] = 'textbox';
$modversion['config'][4]['valuetype'] = 'int';
$modversion['config'][4]['default'] = 600;

$modversion['config'][5]['name'] = 'maximgheight';
$modversion['config'][5]['title'] = '_MI_KUHT_IMGHEIGHT';
$modversion['config'][5]['description'] = '_MI_KUHT_IMGHEIGHTDSC';
$modversion['config'][5]['formtype'] = 'textbox';
$modversion['config'][5]['valuetype'] = 'int';
$modversion['config'][5]['default'] = 600;

$modversion['config'][6]['name'] = 'updatethumbs';
$modversion['config'][6]['title'] = '_MI_KUHT_UPDATETHUMBS';
$modversion['config'][6]['description'] = '';
$modversion['config'][6]['formtype'] = 'yesno';
$modversion['config'][6]['valuetype'] = 'int';
$modversion['config'][6]['default'] = 0;

//news block config
$modversion['config'][7]['name'] = 'newsthumbs';
$modversion['config'][7]['title'] = '_MI_KUHT_NEWSSHOWTHUMBS';
$modversion['config'][7]['description'] = '_MI_KUHT_NEWSSHOWTHUMBSDSC';
$modversion['config'][7]['formtype'] = 'yesno';
$modversion['config'][7]['valuetype'] = 'int';
$modversion['config'][7]['default'] = 0;

$modversion['config'][8]['name'] = 'retainimgsize';
$modversion['config'][8]['title'] = '_MI_KUHT_RETAINIMGSIZE';
$modversion['config'][8]['description'] = '_MI_KUHT_RETAINIMGSIZEDSC';
$modversion['config'][8]['formtype'] = 'yesno';
$modversion['config'][8]['valuetype'] = 'int';
$modversion['config'][8]['default'] = 1;

$modversion['config'][9]['name'] = 'dmaximgwidth';
$modversion['config'][9]['title'] = '_MI_KUHT_DIMGWIDTH';
$modversion['config'][9]['description'] = '_MI_KUHT_DIMGWIDTHDSC';
$modversion['config'][9]['formtype'] = 'textbox';
$modversion['config'][9]['valuetype'] = 'int';
$modversion['config'][9]['default'] = 300;

$modversion['config'][10]['name'] = 'dmaximgheight';
$modversion['config'][10]['title'] = '_MI_KUHT_DIMGHEIGHT';
$modversion['config'][10]['description'] = '_MI_KUHT_DIMGHEIGHTDSC';
$modversion['config'][10]['formtype'] = 'textbox';
$modversion['config'][10]['valuetype'] = 'int';
$modversion['config'][10]['default'] = 150;

$modversion['config'][11]['name'] = 'imagequality';
$modversion['config'][11]['title'] = '_MI_KUHT_QUALITY';
$modversion['config'][11]['description'] = '_MI_KUHT_RETAINIMGSIZEDSC';
$modversion['config'][11]['formtype'] = 'textbox';
$modversion['config'][11]['valuetype'] = 'int';
$modversion['config'][11]['default'] = 100;

$modversion['config'][12]['name'] = 'titlelenght';
$modversion['config'][12]['title'] = '_MI_KUHT_TITLECHARS';
$modversion['config'][12]['formtype'] = 'textbox';
$modversion['config'][12]['valuetype'] = 'int';
$modversion['config'][12]['default'] = 45;

$modversion['config'][13]['name'] = 'showmoreart';
$modversion['config'][13]['title'] = '_MI_KUHT_MORE_LINKS';
$modversion['config'][13]['description'] = '_';
$modversion['config'][13]['formtype'] = 'yesno';
$modversion['config'][13]['valuetype'] = 'int';
$modversion['config'][13]['default'] = 1;

$modversion['config'][14]['name'] = 'perpage';
$modversion['config'][14]['title'] = '_MI_KUHT_DISP';
$modversion['config'][14]['description'] = '';
$modversion['config'][14]['formtype'] = 'select';
$modversion['config'][14]['valuetype'] = 'int';
$modversion['config'][14]['default'] = 5;
$modversion['config'][14]['options'] = array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '10' => 10, '15' => 15, '20' => 20 );

$modversion['config'][15]['name'] = 'showtopicbox';
$modversion['config'][15]['title'] = '_MI_KUHT_TOPICS';
$modversion['config'][15]['description'] = '_';
$modversion['config'][15]['formtype'] = 'yesno';
$modversion['config'][15]['valuetype'] = 'int';
$modversion['config'][15]['default'] = 0;

$modversion['config'][16]['name'] = 'showteaser';
$modversion['config'][16]['title'] = '_MI_KUHT_TEXTVIEW';
$modversion['config'][16]['description'] = '';
$modversion['config'][16]['formtype'] = 'yesno';
$modversion['config'][16]['valuetype'] = 'int';
$modversion['config'][16]['default'] = 0;

$modversion['config'][17]['name'] = 'textchars';
$modversion['config'][17]['title'] = '_MI_KUHT_HOMETEXTCHARS';
$modversion['config'][17]['description'] = '_MI_KUHT_HOMETEXTDSC';
$modversion['config'][17]['formtype'] = 'textbox';
$modversion['config'][17]['valuetype'] = 'int';
$modversion['config'][17]['default'] = 100;

$modversion['config'][18]['name'] = 'ministats';
$modversion['config'][18]['title'] = '_MI_KUHT_INCSTATS';
$modversion['config'][18]['description'] = '';
$modversion['config'][18]['formtype'] = 'yesno';
$modversion['config'][18]['valuetype'] = 'int';
$modversion['config'][18]['default'] = 1;

$modversion['config'][19]['name'] = 'remimgmain';
$modversion['config'][19]['title'] = '_MI_KUHT_REMIMGMAIN';
$modversion['config'][19]['description'] = '';
$modversion['config'][19]['formtype'] = 'yesno';
$modversion['config'][19]['valuetype'] = 'int';
$modversion['config'][19]['default'] = 0;

$modversion['config'][20]['name'] = 'remimgteas';
$modversion['config'][20]['title'] = '_MI_KUHT_REMIMGTEAS';
$modversion['config'][20]['description'] = '';
$modversion['config'][20]['formtype'] = 'yesno';
$modversion['config'][20]['valuetype'] = 'int';
$modversion['config'][20]['default'] = 1;

$modversion['config'][21]['name'] = 'templatetype';
$modversion['config'][21]['title'] = '_MI_KUHT_CHOOSETEMPLATE';
$modversion['config'][21]['description'] = '_MI_KUHT_CHOOSETEMPLATEDESC';
$modversion['config'][21]['formtype'] = 'yesno';
$modversion['config'][21]['valuetype'] = 'int';
$modversion['config'][21]['default'] = 1;

//wfsection block config
$modversion['config'][22]['name'] = 'wfssthumbs';
$modversion['config'][22]['title'] = '_MI_KUHT_WFSSHOWTHUMBS';
$modversion['config'][22]['description'] = '_MI_KUHT_WFSSHOWTHUMBSDSC';
$modversion['config'][22]['formtype'] = 'yesno';
$modversion['config'][22]['valuetype'] = 'int';
$modversion['config'][22]['default'] = 0;

$modversion['config'][23]['name'] = 'wfretainimgsize';
$modversion['config'][23]['title'] = '_MI_KUHT_WFRETAINIMGSIZE';
$modversion['config'][23]['description'] = '_MI_KUHT_RETAINIMGSIZEDSC';
$modversion['config'][23]['formtype'] = 'yesno';
$modversion['config'][23]['valuetype'] = 'int';
$modversion['config'][23]['default'] = 1;

$modversion['config'][24]['name'] = 'wfdmaximgwidth';
$modversion['config'][24]['title'] = '_MI_KUHT_WFDIMGWIDTH';
$modversion['config'][24]['description'] = '_MI_KUHT_DIMGWIDTHDSC';
$modversion['config'][24]['formtype'] = 'textbox';
$modversion['config'][24]['valuetype'] = 'int';
$modversion['config'][24]['default'] = 300;

$modversion['config'][25]['name'] = 'wfdmaximgheight';
$modversion['config'][25]['title'] = '_MI_KUHT_WFDIMGHEIGHT';
$modversion['config'][25]['description'] = '_MI_KUHT_DIMGHEIGHTDSC';
$modversion['config'][25]['formtype'] = 'textbox';
$modversion['config'][25]['valuetype'] = 'int';
$modversion['config'][25]['default'] = 150;

$modversion['config'][26]['name'] = 'wfimagequality';
$modversion['config'][26]['title'] = '_MI_KUHT_WFQUALITY';
$modversion['config'][26]['description'] = '_MI_KUHT_WFQUALITYDSC';
$modversion['config'][26]['formtype'] = 'textbox';
$modversion['config'][26]['valuetype'] = 'int';
$modversion['config'][26]['default'] = 100;

$modversion['config'][27]['name'] = 'wftitlelenght';
$modversion['config'][27]['title'] = '_MI_KUHT_WFTITLECHARS';
$modversion['config'][27]['formtype'] = 'textbox';
$modversion['config'][27]['valuetype'] = 'int';
$modversion['config'][27]['default'] = 45;

$modversion['config'][28]['name'] = 'wfshowmoreart';
$modversion['config'][28]['title'] = '_MI_KUHT_WFMORE_LINKS';
$modversion['config'][28]['description'] = '_';
$modversion['config'][28]['formtype'] = 'yesno';
$modversion['config'][28]['valuetype'] = 'int';
$modversion['config'][28]['default'] = 1;

$modversion['config'][29]['name'] = 'wfperpage';
$modversion['config'][29]['title'] = '_MI_KUHT_WFDISP';
$modversion['config'][29]['description'] = '';
$modversion['config'][29]['formtype'] = 'select';
$modversion['config'][29]['valuetype'] = 'int';
$modversion['config'][29]['default'] = 5;
$modversion['config'][29]['options'] = array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '10' => 10, '15' => 15, '20' => 20 );

$modversion['config'][30]['name'] = 'wfshowtopicbox';
$modversion['config'][30]['title'] = '_MI_KUHT_WFTOPICS';
$modversion['config'][30]['description'] = '_';
$modversion['config'][30]['formtype'] = 'yesno';
$modversion['config'][30]['valuetype'] = 'int';
$modversion['config'][30]['default'] = 0;

$modversion['config'][31]['name'] = 'wfshowteaser';
$modversion['config'][31]['title'] = '_MI_KUHT_WFTEXTVIEW';
$modversion['config'][31]['description'] = '';
$modversion['config'][31]['formtype'] = 'yesno';
$modversion['config'][31]['valuetype'] = 'int';
$modversion['config'][31]['default'] = 0;

$modversion['config'][32]['name'] = 'wftextchars';
$modversion['config'][32]['title'] = '_MI_KUHT_WFHOMETEXTCHARS';
$modversion['config'][32]['description'] = '_MI_KUHT_WFHOMETEXTDSC';
$modversion['config'][32]['formtype'] = 'textbox';
$modversion['config'][32]['valuetype'] = 'int';
$modversion['config'][32]['default'] = 100;

$modversion['config'][33]['name'] = 'wfministats';
$modversion['config'][33]['title'] = '_MI_KUHT_WFINCSTATS';
$modversion['config'][33]['description'] = '';
$modversion['config'][33]['formtype'] = 'yesno';
$modversion['config'][33]['valuetype'] = 'int';
$modversion['config'][33]['default'] = 1;

$modversion['config'][34]['name'] = 'wfremimgmain';
$modversion['config'][34]['title'] = '_MI_KUHT_WFREMIMGMAIN';
$modversion['config'][34]['description'] = '';
$modversion['config'][34]['formtype'] = 'yesno';
$modversion['config'][34]['valuetype'] = 'int';
$modversion['config'][34]['default'] = 0;

$modversion['config'][35]['name'] = 'wfremimgteas';
$modversion['config'][35]['title'] = '_MI_KUHT_WFREMIMGTEAS';
$modversion['config'][35]['description'] = '';
$modversion['config'][35]['formtype'] = 'yesno';
$modversion['config'][35]['valuetype'] = 'int';
$modversion['config'][35]['default'] = 1;

$modversion['config'][36]['name'] = 'wftemplatetype';
$modversion['config'][36]['title'] = '_MI_KUHT_WFCHOOSETEMPLATE';
$modversion['config'][36]['description'] = '_MI_KUHT_CHOOSETEMPLATEDESC';
$modversion['config'][36]['formtype'] = 'yesno';
$modversion['config'][36]['valuetype'] = 'int';
$modversion['config'][36]['default'] = 1;
?>
