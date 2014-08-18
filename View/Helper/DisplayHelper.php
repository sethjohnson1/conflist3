<?php

class DisplayHelper extends AppHelper {
  /*
  public function __construct(View $view, $settings = array()) {
    parent::__construct($view, $settings);
    //debug($settings);
  }
  */

  /*
  function gcal_url($id, $start_date, $end_date, $title, $city, $country, $url, $conflist_url,$conflist_name) {
    $start_string = str_replace('-','',$start_date);
    $end_string = date('Ymd',strtotime($end_date." +1 day"));
    $location = $city."; ".$country;
    $Gcal_url = "http://www.google.com/calendar/event?action=TEMPLATE&".
      "text=".urlencode($title)."&".
      "dates=".$start_string."/".$end_string.
      "&details=".$url.
      "&location=".urlencode($location).
      "&trp=false&sprop=".urlencode($conflist_url).
      "&sprop=name:".urlencode($conflist_name);
    return $Gcal_url;
  }
  */
  public function announcementArray($conference_data) {
    return array(array(__('Start Date'), $conference_data['start_date']));
  }

  public function announcementText($conference_data) {
    $output = '';
    foreach (announcementArray($conference_data) as $entry) {
      $output .= $entry[0] . ': ' . $entry[1] . "\n";
    }
    return $output;
  }

  public function announcementHtml($conference_data) {
    $output = '';
    foreach (announcementArray($conference_data) as $entry) {
      $output .= '<dt>' . $entry[0] . "</dt>\n";
      $output .= '<dd>' . $entry[1] . "&nbsp;</dd>\n";
    }
    return $output;
  }

}
?>