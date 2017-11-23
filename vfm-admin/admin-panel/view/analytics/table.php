<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <strong><?php print $encodeExplorer->getString("actions"); ?></strong>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table statistics table-hover table-condensed" id="sortanalytics" width="100%">
                      <thead>
                          <tr>
                              <th><span class="sorta"><?php print $encodeExplorer->getString("day"); ?></span></th>
                              <th><span class="sorta">hh:mm:ss</span></th>
                              <th><span class="sorta"><?php print $encodeExplorer->getString("user"); ?></span></th>
                              <th><span class="sorta"><?php print $encodeExplorer->getString("action"); ?></span></th>
                              <th><span class="sorta"><?php print $encodeExplorer->getString("type"); ?></span></th>
                              <th><span class="sorta"><?php print $encodeExplorer->getString("file_name"); ?></span></th>
                          </tr>
                       </thead>
                       <tbody>
<?php
foreach ($logs as $log) { 
        $ext = substr($log, -4); 
    if ($ext == "json") { 
        $resultnew = json_decode(file_get_contents('log/'.$log), true);
        $result = array_merge($result, $resultnew);
    }
}
$numup = 0;
$numdel = 0;
$numplay = 0;
$numdown = 0;

$polarplay = array();
$polardown = array();

$polardowncount = 0;
$polarplaycount = 0;

foreach ($result as $key => $value) {
    //echo "DAY: ".$key."<br>";
    foreach ($value as $kiave => $day) {

        $item = $day['item'];

        if ($day['action'] == 'ADD') {
            $numup++;
            $contextual = "success";
        } 
        if ($day['action'] == 'REMOVE') {
            $numdel++;
            $contextual = "danger";
        }
        if ($day['action'] == 'PLAY') {
            $numplay++;
            $polarplaycount++;
            if (isset($polarplay[$item])) {
                $polarplay[$item] = $polarplay[$item] +1;
            } else {
                $polarplay[$item] = 1;
            }
            $contextual = "warning";
        }
        if ($day['action'] == 'DOWNLOAD') {
            $numdown++;
            $polardowncount++;
            if (isset($polardown[$item])) {
                $polardown[$item] = $polardown[$item] +1;
            } else {
                $polardown[$item] = 1;
            }
            $contextual = "info";
        }
        echo "<tr class=\"".$contextual."\">";

        echo "<td>".$key."</td>";
        echo "<td>".$day['time']."</td>";
        echo "<td>".$day['user']."</td>";
        echo "<td>".$encodeExplorer->getString(strtolower($day['action']))."</td>";
        echo "<td>".$day['type']."</td>";
        echo "<td>".$day['item']."</td>";
    }
}
?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><span class="sorta"><?php print $encodeExplorer->getString("day"); ?></span></td>
                                <td><span class="sorta">hh:mm:ss</span></td>
                                <td><span class="sorta"><?php print $encodeExplorer->getString("user"); ?></span></td>
                                <td><span class="sorta"><?php print $encodeExplorer->getString("action"); ?></span></td>
                                <td><span class="sorta"><?php print $encodeExplorer->getString("type"); ?></span></td>
                                <td><span class="sorta"><?php print $encodeExplorer->getString("item"); ?></span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>