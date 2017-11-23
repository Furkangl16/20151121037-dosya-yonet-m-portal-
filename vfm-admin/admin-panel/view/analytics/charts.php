<div class="row">
    <div class="col-lg-3">
        <div class="row" id="mainLegend">
        </div>
    </div>

    <div class="col-lg-9">
        <div class="row">
            <div class="col-sm-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <strong><?php print $encodeExplorer->getString("main_activities"); ?></strong>
                    </div>
                    <div class="box-body">
                        <div class="canvas-holder">
                            <canvas class="chart" id="pie" height="400" width="400"></canvas>
                            <div class="showdata"></div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-sm-4" id="chart-download">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <i class="fa fa-cloud-download"></i> 
                        <strong><?php print $encodeExplorer->getString("downloads"); ?></strong> <span class="num-down"></span>
                    </div>
                    <div class="box-body">
                        <div class="canvas-holder">
                            <canvas class="chart" id="polar-down" width="400" height="400"></canvas>
                            <div class="showdata screen-down"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4" id="chart-play">

                <div class="box box-warning">
                    <div class="box-header with-border">
                        <i class="fa fa-play-circle-o"></i> 
                        <strong><?php print $encodeExplorer->getString("play"); ?> <span class="num-play"></span></strong>
                    </div>
                    <div class="box-body">
                        <div class="canvas-holder"> 
                            <canvas class="chart" id="polar-play" width="400" height="400"></canvas>
                            <div class="showdata screen-play"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- row -->
    </div>
</div> <!-- row -->