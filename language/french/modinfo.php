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
define('_MI_KUHT_NAME',' A la Une');

// A brief description of this module
define('_MI_KUHT_DESC',' Place un article dans le bloc central de la Une.');

// Names of blocks for this module (Not all module has blocks)
define('_MI_KUHT_BNAME','A la Une - Actualit&eacute;s');
define('_MI_KUHT_BNAME1','A la Une - WF-Sections');

// Names of admin menu items
define('_MI_KUHT_ADMENU1','Configuration gt&eacute;n&eacute;rale');
define('_MI_KUHT_ADMENU2','Bloc Actualit&eacute;s');
define('_MI_KUHT_ADMENU3','Bloc WF-Section');
define('_MI_KUHT_ADMENU4','Mini Spotlights');
define('_MI_KUHT_ADMENU5','Applet de Ticker d\'actualit&eacute;');

define('_MI_KUHT_UPLOADDIR','R&eacute;pertoire de t&eacute;l&eacute;chargement d\'images (sans slash)');
define('_MI_KUHT_WFUPLOADDIR','R&eacute;pertoire de t&eacute;l&eacute;chargement image WF-Section (sans anti slash)');
define('_MI_KUHT_LINKIMAGES','R&eacute;pertoire de T&eacute;l&eacute;chargement d\'Image de la Une (sans slash)');
define('_MI_KUHT_MAXFILESIZE','Taille max de t&eacute;l&eacute;chargement');
define('_MI_KUHT_IMGWIDTH','Largeur maximale de l\'image t&eacute;l&eacute;charg&eacute;e ');
define('_MI_KUHT_IMGHEIGHT','Hauteur maximale de l\'image t&eacute;l&eacute;charg&eacute;e ');
define('_MI_KUHT_UPDATETHUMBS','Toujours mettre &agrave; jour les vignettes?');

define('_MI_KUHT_NEWSSHOWTHUMBS','Utiliser une vignette pour l\'image des actualit&eacute;s ?');
define('_MI_KUHT_DIMGWIDTH','Largeur de l\'image des actualit&eacute;s visualis&eacute;e');
define('_MI_KUHT_DIMGHEIGHT','Hauteur de l\'image des actualit&eacute;s visualis&eacute;e');
define('_MI_KUHT_RETAINIMGSIZE','Utiliser la taille actuelle de l\'image de l\'actualit&eacute; ?');
define('_MI_KUHT_PERPAGE', 'Nombre maximum d\'actualit&eacute;s &agrave; afficher ?');
define('_MI_KUHT_MORE_LINKS','Montrer la liste des autres actualit&eacute;s ?');
define('_MI_KUHT_TITLECHARS','Longueur du titre de l\'actualit&eacute; mise &agrave; la Une');
define('_MI_KUHT_DISP','Nombre d\articles d\'actualit&eacute;s &agrave; afficher');
define('_MI_KUHT_TOPICS','Montrer la boite de s&eacute;lection des cat&eacute;gories d\'actualit&eacute;s ?'); // By Romu R&B.
define('_MI_KUHT_TEXTVIEW', 'Montrer le corps de texte des actualit&eacute;s ?');
define('_MI_KUHT_INCSTATS','Inclure la ligne de ministats des actualit&eacute;s ?');
define('_MI_KUHT_HOMETEXTCHARS', 'Longueur des corps de texte des actualit&eacute;s &agrave; la Une');
define('_MI_KUHT_HOMETEXTDSC','En nombre de lettres. 0 = Texte complet. (Valable que pour les articles Non-Html)');
define('_MI_KUHT_CHOOSETEMPLATE','Choisir le gabarit &agrave; deux colonnes ?');
define('_MI_KUHT_CHOOSETEMPLATEDESC','Un gabarit de forme empil&eacute;e sera utilis&eacute; si NON est s&eacute;lectionn&eacute;');
define('_MI_KUHT_ORDER','Ordre de visualisation des articles des actualit&eacute;s');
define('_MI_KUHT_QUALITY','Qualit&eacute; d\'image des actualit&eacute;s');
define('_MI_KUHT_STOPSHOUTING','Sans tronquage de titres');
define('_MI_KUHT_REMIMGMAIN','D&eacute;placer les images des principaux nouveaux articles Spotlight?');
define('_MI_KUHT_REMIMGTEAS','D&eacute;placer les images du News Teasers?');

define('_MI_KUHT_WFSSHOWTHUMBS','Utiliser Thumbnail pour l\'image des WF-Section?');
define('_MI_KUHT_WFDIMGWIDTH','Largeur de l\'image de la WF-Section visualis&eacute;e');
define('_MI_KUHT_WFDIMGHEIGHT','Hauteur de l\'image de la WF-Section visualis&eacute;e');
define('_MI_KUHT_WFRETAINIMGSIZE','Utiliser la taille actuelle de l\'image de la WF-Section?');
define('_MI_KUHT_WFPERPAGE', 'Nombre maximum d\'articles de WF-Section &agrave; Afficher ?');
define('_MI_KUHT_WFMORE_LINKS','Montrer la liste des autres WF-Section ?');
define('_MI_KUHT_WFTITLECHARS','Longueur du titre de l\'article de la WF-Section mise &agrave; la Une');
define('_MI_KUHT_WFDISP','Nombre d\'articles de WF-Section &agrave; Afficher');
define('_MI_KUHT_WFTOPICS','Montrer la Boite de S&eacute;lection des Cat&eacute;gories des WF-Section ?'); // By Romu R&B.
define('_MI_KUHT_WFTEXTVIEW', 'Montrer le corps de texte des articles WF-Section ?');
define('_MI_KUHT_WFINCSTATS','Inclure la ligne de Ministats des WF-Section ?');
define('_MI_KUHT_WFHOMETEXTCHARS', 'Longueur des corps de texte des WF-Section mis &agrave; la Une');
define('_MI_KUHT_WFHOMETEXTDSC','En nombre de lettres. 0 = Texte complet. (Valable que pour les articles Non-Html)');
define('_MI_KUHT_WFCHOOSETEMPLATE','Choisir le gabarit WF-Section &agrave; deux colonnes?');
define('_MI_KUHT_WFCHOOSETEMPLATEDESC','Un gabarit de forme empil&eacute;e sera utilis&eacute; si NON est s&eacute;lectionn&eacute;');
define('_MI_KUHT_WFORDER','Ordre de visualisation des Articles des WF-Section');
define('_MI_KUHT_WFQUALITY','Qualit&eacute; d\'image des WF-Section');
define('_MI_KUHT_WFREMIMGMAIN','D&eacute;placer les images du principale article WF-Section?');
define('_MI_KUHT_WFREMIMGTEAS','D&eacute;placer les images du WF-Section Article Teasers?');

?>
