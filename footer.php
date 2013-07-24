<?php
/* 
Monistrap by Sungbin Jeon (clockoon@gmail.com)
Date: 
Version: alpha 1

GPL
 */
?>
</div>
</div>

<div id="push"></div>
</div>
</div>
<div id='wikiFooter' style='background-color:#efefef;padding:8px;'>
<div class='container'>
<?php
$banner= <<<FOOT
 <a href="$validator_xhtml"><img
  src="$this->themeurl/imgs/xhtml.png"
  style='border:0;vertical-align:middle' width="80" height="15"
  alt="Valid XHTML 1.0!" /></a>

 <a href="$validator_css"><img
  src="$this->themeurl/imgs/css.png"
  style='border:0;vertical-align:middle' width="80" height="15"
  alt="Valid CSS!" /></a>

 <a href="http://moniwiki.sourceforge.net/"><img
  src="$this->themeurl/imgs/moniwiki-powered-thin.png"
  style='border:0;vertical-align:middle' width="80" height="15"
  alt="powered by MoniWiki" /></a>
FOOT;
?>
<?php
  print '<div class="muted credit pull-right" id="wikiBanner">powered by <a href="http://http://moniwiki.kldp.net">Moniwiki</a> | themed by clockoon</div>';
  if (!empty($lastedit))
    print "<small class='muted'>last modified $lastedit $lasttime<br />";
  if (!empty($timer))
    print 'Processing time '.$timer;
  //print "<pre>".$options['timer']->Write()."</pre>";
  print '</small></div></div>';