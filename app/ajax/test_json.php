<?php
function random(){
  return rand(1, 12);
}


$data = array(
      array('Date', 'RPM'),
      array("Apr 10",random()),
      array("Apr 9", random()),
      array("Apr 8",random()),
      array("Apr 7",random()),
      array("Apr 6",random()),
      array("Apr 5",random()),
      array("Apr 4",random()),
      array("Apr 3",random()),
      array("Apr 2",random()),
      array("Apr 1",random()),
    
  );
  
  $json = json_encode($data);
  echo $json;