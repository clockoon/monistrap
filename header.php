<?php 
/* 
Monistrap by Sungbin Jeon (clockoon@gmail.com)
Date: 
Version: alpha 1

GPL
 */

function function_toc($formatter) {
    $secdep = '';
    $simple = 1;

    $head_num=1;
    $head_dep=0;

    $body=$formatter->page->get_raw_body();
    $body=preg_replace("/\{\{\{.+?\}\}\}/s",'',$body);
    $lines=explode("\n",$body);

    $toc = array();
    foreach ($lines as $line) {
        preg_match("/(?<!=)(={1,$secdep})\s(#?)(.*)\s+\\1\s?$/",$line,$match);
        if (!$match) continue;

        $dep=strlen($match[1]);
        if ($dep > 4) $dep = 5;
        $head=str_replace("<","&lt;",$match[3]);
        # strip some basic wikitags
        # $formatter->baserepl,$head);
        #$head=preg_replace($formatter->baserule,"\\1",$head);
        # do not strip basic wikitags
        $head=preg_replace($formatter->baserule,$formatter->baserepl,$head);
        $head=preg_replace("/\[\[.*\]\]/","",$head);
        $head=preg_replace("/(".$formatter->wordrule.")/e",
            "\$formatter->link_repl('\\1')",$head);

        if ($simple)
            $head=strip_tags($head);
            #$head=strip_tags($head,'<b><i><sub><sup><del><tt><u><strong>');

        if (!$depth_top) { $depth_top=$dep; $depth=1; }
        else {
            $depth=$dep - $depth_top + 1;
            if ($depth <= 0) $depth=1;
        }

        $num="".$head_num;
        $odepth=$head_dep;
        $open="";
        $close="";

        if ($match[2]) {
            # reset TOC numberings
            $dum=explode(".",$num);
            $i=sizeof($dum);
            for ($j=0;$j<$i;$j++) $dum[$j]=1;
            $dum[$i-1]=0;
            $num=join($dum,'.');
            if ($prefix) $prefix++;
            else $prefix=1;
        }

        if ($odepth && ($depth > $odepth)) {
            $num.='.1';
        } else if ($odepth) {
            $dum=explode('.',$num);
            $i=sizeof($dum)-1;
            while ($depth < $odepth && $i > 0) {
                unset($dum[$i]);
                $i--;
                $odepth--;
            }
            $dum[$i]++;
            $num=join($dum,'.');
        }
        $head_dep=$depth; # save old
        $head_num=$num;

        $toc["$num"]=$head;
    }

if (count($toc)>2 && !in_array($formatter->page->name,$formatter->notoc)){
	$output="<div class='well' style='padding:8px 0;'><ul class='nav nav-list'><li class='nav-header'>목차</li>";
	foreach($toc as $key=>$val){
		$output.="<li><a href=".$formatter->link_url($formatter->page->name."#s-".$key).">".str_repeat("&nbsp;",substr_count($key,".")*3).$key."&nbsp;".$val."</a></li>";
	}
		$output.="</ul></div>";
return $output;

}

}

if (!empty($DBInfo->use_scrap))
  include_once("plugin/scrap.php");
?>
<script src="<?php echo $themeurl;?>/js/jquery-2.0.3.min.js"></script>
<script src="<?php echo $themeurl;?>/js/bootstrap.js"></script>
<div id="wrap">
<!-- navigation bar -->
<div class='navbar-fixed-top navbar navbar-inverse'>
	<div class="navbar-inner">
		<div class="container">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<span class="brand hidden-desktop"><?php echo $DBInfo->sitename; ?></span>
			<?php 
				$nav_strip=array("id=\"wikiMenu\"","<ul>","</div>");
				$nav_replace=array("class='nav-collapse collapse'","<ul class='nav'>","");
				echo str_replace($nav_strip,$nav_replace,$menu);?>
				<div id='goForm'>
					<form id='go' action='' class='navbar-search pull-right' method='get' onsubmit="return moin_submit();">
						<input type='text' name='value' size='20' accesskey='s' class='search-query goto' placeholder='search'/>
						<input type='hidden' name='action' value='goto' />
						
					</form>
				</div>
				</div><!--/.nav-collapse -->
		</div>
	</div>
</div>

<div id='mainbody' class='container'>
<?php empty($msg) ? '' : print $msg; ?>
<?php echo $subindex;?>
<div id='container' class='row'>
<div class='span3'>
	<?php echo '<div class="page-header visible-desktop"><h1>'.$DBInfo->sitename.'</h1></div>'; ?>
	<?php echo '<div class="wikiTitle visible-phone"><h1>'.$title.'</h1></div>';?>
	<div class='pagination visible-phone'><ul>
	<li><a href="<?php echo $this->link_url($this->page->name.'?action=edit');?>"><i class="icon-edit"></i></a></li>
	<li><a href="<?php echo $this->link_url($this->page->name.'?action=diff');?>"><i class="icon-list"></i></a></li>
	<li><a href="<?php echo $this->link_url($this->page->name.'?action=info');?>"><i class="icon-info-sign"></i></a></li>
	<li><a href="<?php echo $this->link_url($this->page->name.'?action=print');?>"><i class="icon-print"></i></a></li>
	<li><a href="<?php echo $this->link_url($this->page->name.'?action=rename');?>"><i class="icon-pencil"></i></a></li>
	<li><a href="<?php echo $this->link_url($this->page->name.'?action=DeletePage');?>"><i class="icon-trash"></i></a></li>
	<li><a href="<?php echo $this->link_url($this->page->name.'?action=Backlinks');?>"><i class="icon-retweet"></i></a></li></ul>
</div>
	<?php print function_toc($this); ?>
<ul class='nav nav-tabs nav-stacked hidden-phone'>
	<li><a href="<?php echo $this->link_url($this->page->name.'?action=edit');?>"><i class="icon-edit"></i>&nbsp;&nbsp;Edit</a></li>
	<li><a href="<?php echo $this->link_url($this->page->name.'?action=diff');?>"><i class="icon-list"></i>&nbsp;&nbsp;Diff</a></li>
	<li><a href="<?php echo $this->link_url($this->page->name.'?action=info');?>"><i class="icon-info-sign"></i>&nbsp;&nbsp;Info</a></li>
	<li><a href="<?php echo $this->link_url($this->page->name.'?action=print');?>"><i class="icon-print"></i>&nbsp;&nbsp;Print</a></li>
	<li><a href="<?php echo $this->link_url($this->page->name.'?action=rename');?>"><i class="icon-pencil"></i>&nbsp;&nbsp;Rename</a></li>
	<li><a href="<?php echo $this->link_url($this->page->name.'?action=DeletePage');?>"><i class="icon-trash"></i>&nbsp;&nbsp;Delete</a></li>
	<li><a href="<?php echo $this->link_url($this->page->name.'?action=Backlinks');?>"><i class="icon-retweet"></i>&nbsp;&nbsp;Backlinks</a></li>
</ul>

	<?php //print_r($this); ?>
</div>
<!-- ?php echo '<div id="wikiTrailer"><p><span>'.$trail.'</span></p></div>';?i -->
<div id='mycontent' class='span7'>
<?php echo '<div class="wikiTitle hidden-phone" id="wikiTitle"><h1>'.$title.'</h1></div>';?>
<?php
if (empty($options['action']) and !empty($DBInfo->use_scrap)) {
  $scrap = macro_Scrap($this);
  if (!empty($scrap)) {
    echo "<div class='scrap'>";
    echo $scrap;
    echo "</div>";
  }
}
?>
