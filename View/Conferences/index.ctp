<!-- social networking buttons -->
<!-- currently disabled
<div class="share-links">
  <div class="g-plusone" data-href="<? echo Configure::read('site.home'); ?>"></div>
  <div style="display: inline-block;"><a href="https://twitter.com/share" class="twitter-share-button" 
    data-text="check out <? echo Configure::read('site.name'); ?>"
    data-hashtags="MathConferences" 
    data-url="<? echo Configure::read('site.home');?>">Tweet</a></div>
</div>
-->

<?php

/*
echo $this->Js->link(array(
'https://apis.google.com/js/plusone.js', 
'http://platform.twitter.com/widgets.js', 
), false);
*/

/*
function gcal_link($start,$end,$title,$location) {
  $start_string = str_replace('-','',$start);
  $end_string = date('Ymd',strtotime($end." +1 day"));
  $url = "http://www.google.com/calendar/event?action=TEMPLATE&".
    "text=".$title."&".
    "dates=".$start_string."/".$end_string.
    "&details=".
    "&location=".$location.
    "&trp=false&sprop=http%3A%2F%2Fwww.nilesjohnson.net%2Falgtop-conf&sprop=name:AlgTop-Conf";
  return $url;
}
*/
?>


<div class="intro_text">
  <p>Welcome to the AlgTop-Conf List!  This is a home for conference
  announcements in algebraic topology and, more generally, mathematics
  meetings which may be of <em>any interest</em> to the algebraic
  topology community.</p>

  <p>There are a few other conference lists available, but this list
  aims to be more complete by allowing <em>anyone at all</em> to add
  announcements.  Rather than use a wiki, announcement information is
  stored in database format so that useful search functions can be
  added as the list grows.</p>

  <h4>Updates 2014-02-16</h4>

  <p>We've upgraded the AlgTop-Conf software to <a
  href="http://cakephp.org/" target="cake-blank">CakePHP 2.4.5</a> and
  <a href="http://www.php.net" target="php-blank">PHP 5.4</a>.  This involves
  substantial changes behind the scenes, but (hopefully!) minimal
  changes to the user interface.  If you notice something not working
  properly, please let Niles know.</p>

  <p>Additional update notes are available in the <a href="https://github.com/nilesjohnson/conference-list/commits/master" target="github">commit history</a> (GitHub).</p>

  <div class="new">
    <h2>Know of a meeting not listed here?  Add it now!</h2>
    <p>
    <?php echo $this->Html->link('New Announcement', array('action' => 'add'), array('class' => 'button', 'id' => 'add-button'));?>
    </p>
  </div>
</div>


<hr/>
<h1><?php echo $view_title; ?></h1>


<div class="search_links">

<?php 

//just added this to show basic Paginator function
/*
echo '<div>';

//notice clicking this will change from ASC to DESC it also changes the class name so you can draw a little arrow. Check out the default CakePHP CSS you'll see it
echo $this->Paginator->sort('country').'<br/>';


	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	)).'<br />';

		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));


echo '</div>';
*/

//

		echo $this->Form->create('Conference');
		//the multi-select happens magically because of the HABTM and the variable $tags
        echo $this->Form->input('Tag',array('value'=>$tagids));
		//disables the SecurityComponent
		//$this->Form->unlockField('Tag');
        echo $this->Form->submit(__('Search', true), array('div' => false));
        echo $this->Form->end();


?>

<div><p>
Last tag search is saved in a cookie.
<?php echo $this->Html->link('Delete saved tags', array('controller' => 'conferences', 'action'=>'index', '?'=>array('t0' => '')));?>
</p></div>

  <?php echo $sort_text ?>
  <?php foreach ($search_links as $name => $array): ?>
  <?php echo $this->Html->link($name, $array)." "; ?>
  <?php endforeach; ?>

  <div style="float:right;">
    <?php echo $this->Html->link('Include Past',$past_link)?>
    |
    <?php echo $this->Html->link('RSS','/conferences/index.rss');?>
  </div>
</div>




<?php $curr_subsort = Null; $new_subsort = Null; $subsort_counter = 0; echo '<div id="subsort_start">'; ?>
<?php 
$site_url = Configure::read('site.home');
$site_name = Configure::read('site.name');
foreach ($conferences as $conference):
if ($sort_condition == Null || $sort_condition == 'all') {
  $datearray = explode("-",$conference['Conference']['start_date']); 
  $new_subsort =  $months[(int)$datearray[1]]." ".$datearray[0]; 
 }
if ($sort_condition == 'country') {
  $new_subsort = $conference['Conference']['country'];
 }
if ($new_subsort != $curr_subsort) {
  echo '</div>';
  $curr_subsort = $new_subsort;
  echo '<div class="subsort' . $subsort_counter . '">';
  echo '<h2>' . $new_subsort . '</h2>';
  $subsort_counter += 1; 
  $subsort_counter = $subsort_counter % 2;
 }
 
 


?>

<h3 class="title">
<?php echo '<a href="'.
   $conference['Conference']['homepage'].
   '">'.
   $conference['Conference']['title'].
   '</a>'
   ;?>
</h3>
<div class="conference">

<div class="calendars">
<?php  echo
  $this->Html->link('Google calendar',
  $this->Gcal->gcal_url($conference['Conference']['id'], 
                               $conference['Conference']['start_date'], 
                               $conference['Conference']['end_date'],
                               $conference['Conference']['title'],
                               $conference['Conference']['city'],
                               $conference['Conference']['country'],
                               $conference['Conference']['homepage'],
			       $site_url,
			       $site_name
                               ),
  array('escape' => false,'class'=>'ics button'));

echo
  $this->Html->link('iCalendar .ics',
  array('action'=>'ical', $conference['Conference']['id']),
  array('escape' => false,'class'=>'ics button'));
?>
</div>

<div class="dates">
   <?php echo $conference['Conference']['start_date']." <small>through</small> ".$conference['Conference']['end_date'];?>
</div>

<?php
      if (!empty($conference['Conference']['institution'])) {
      	 echo "<div class=\"location\">";
      	 echo $conference['Conference']['institution'];
	 echo "</div>";
      }

?>

<div class="location">
<?php 
      echo $conference['Conference']['city']."; ".$conference['Conference']['country'];
?>
</div>

<div class="action">
<a  id="description_<?php echo $conference['Conference']['id'];?>_plus" onclick="
   document.getElementById('description_<?php echo $conference['Conference']['id'];?>').style.display='block'; 
   document.getElementById('description_<?php echo $conference['Conference']['id'];?>_plus').style.display='none'; 
   document.getElementById('description_<?php echo $conference['Conference']['id'];?>_minus').style.display='inline'; 
   return false;" href="#">Description</a>
<a  id="description_<?php echo $conference['Conference']['id'];?>_minus" onclick="
   document.getElementById('description_<?php echo $conference['Conference']['id'];?>').style.display='none'; 
   document.getElementById('description_<?php echo $conference['Conference']['id'];?>_plus').style.display='inline'; 
   document.getElementById('description_<?php echo $conference['Conference']['id'];?>_minus').style.display='none'; 
   return false;" href="#" style="display:none;"> - Description</a>
 | 
<?php echo 
  $this->Html->link('View entry', 
  array('action'=>'view', $conference['Conference']['id']));?>
<!--
 | 
<?php /* echo 
  $this->Html->link('Edit', 
  array('action'=>'edit', $conference['Conference']['id'], $conference['Conference']['edit_key'])); /**/?>
-->

</div>

<div class="conference_minor" id="description_<?php echo $conference['Conference']['id']?>">
<p>Meeting Type: <?php echo $conference['Conference']['meeting_type']?></p>
<p>Subject Area: <?php echo $conference['Conference']['subject_area']?></p>
<p>Contact: <?php echo 
!$conference['Conference']['contact_name'] ? 'see conference website' : $conference['Conference']['contact_name']?></p>


<h3>Description</h3>
<div class="description"><?php echo 
!$conference['Conference']['description'] ? 'none' : $conference['Conference']['description']
?></div>
</div>





</div>

<?php endforeach; ?>

</div>









