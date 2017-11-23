<form class="form-inline selectdate" method="get">
    <input type="hidden" value="go" name="log">
    <div class="form-group">
        <div class="btn-group pull-left">
            <a href="?log=go&range=1" class="btn btn-default <?php if ($range == 1) echo "active"; ?>">
                <span class="fa-stack stackalendar">
                  <i class="fa fa-calendar-o fa-stack-2x"></i>1
                </span>
            </a>
            <a href="?log=go&range=7" class="btn btn-default <?php if ($range == 7) echo "active"; ?>">
                <span class="fa-stack stackalendar">
                    <i class="fa fa-calendar-o fa-stack-2x"></i>7
                </span>
            </a>
            <a href="?log=go&range=30" class="btn btn-default <?php if ($range == 30) echo "active"; ?>">
                <span class="fa-stack stackalendar">
                  <i class="fa fa-calendar-o fa-stack-2x"></i>30
                </span>
            </a>
        </div>
    </div>
    <div class="form-group">
        <?php 
        echo "<select name=\"day\" class=\"form-control\" onchange=\"this.form.submit()\"><option>"
        .$encodeExplorer->getString("select_date")."</option>";
foreach ($loglist as $item) {

$ext = substr($item, -4); 
$name = substr($item, 0, -5);

if ($ext == "json") { 
    print "<option ";
    if ($day == $name) {
        print "selected ";
    }
    print "value=\"".$name."\">".$name."</option>";
}
}
        echo "</select>";
        ?>
    </div>
</form>