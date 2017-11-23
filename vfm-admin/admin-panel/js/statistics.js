$(document).ready(function() {
    var table = $('#sortanalytics').DataTable({
            "aaSorting": [[ 0, "desc" ], [ 1, "desc" ]], // Sort by first column descending
            "iDisplayLength": 25,
            "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],

                    "oLanguage": {
                        "sEmptyTable":      "--",
                        "sInfo":            "_START_ / _END_ - _TOTAL_ ",
                        "sInfoEmpty":       "",
                        "sInfoFiltered":    "",
                        "sInfoPostFix":     "",
                        "sLengthMenu":      "<i class='fa fa-list-ol'></i> _MENU_",
                        "sLoadingRecords":  "<i class='fa fa-refresh fa-spin'></i>",
                        "sProcessing":      "<i class='fa fa-refresh fa-spin'></i>",
                        "sSearch":          "<span class='input-group-addon'><i class='fa fa-search'></i></span> ",
                        "sZeroRecords":     "--",
                        "oPaginate": {
                            "sFirst": "<i class='fa fa-angle-double-left'></i>",
                            "sLast": "<i class='fa fa-angle-double-right'></i>",
                            "sPrevious": "<i class='fa fa-angle-left'></i>",
                            "sNext": "<i class='fa fa-angle-right'></i>"
                        }
                    },
            "aoColumnDefs": [
                { "sType": "html", "aTargets": [ 2 ] }
            ]
    });

    $("#sortanalytics tfoot td").each(function (i) {
        var select = $('<select class="form-control"><option value=""></option></select>')
            .appendTo( $(this).empty() )
            .on( 'change', function () {
                table.column(i)
                    .search( $(this).val() )
                    .draw();
            });
        
            table.column(i).data().unique().sort().each( function (d, j) {
            select.append( '<option value="'+d+'">'+d+'</option>' )
        });
    });
});

/*
*
* Legend (chart.js)
*
*
*/
function legend(parent, data) {
    //parent.className = 'legend';
    var datas = data.hasOwnProperty('datasets') ? data.datasets : data;

    // remove possible children of the parent
    while(parent.hasChildNodes()) {
        parent.removeChild(parent.lastChild);
    }

    datas.forEach(function(d) {

        var container = $('<div class="col-lg-12 col-md-3 col-sm-6"></div>');
        var box = $('<div class="info-box"></div>');
        var fa;
        if (d.color == "#5cb85c") {
            fa = "fa-cloud-upload";
        } else if (d.color == "#d9534f") {
            fa = "fa-trash-o";
        } else if (d.color == "#f0ad4e") {
            fa = "fa-music";
        } else if (d.color == "#5bc0de") {
            fa = "fa-download";
        }
        var icon = '<span style="background-color: '+d.color+'; color: #fff" class="info-box-icon"><i class="fa '+fa+'"></i></span>';
        var boxcontent = '<div class="info-box-content"><span class="info-box-text">'+d.title+'</span><span class="info-box-number">'+d.value+'</span></div>';
        box.append(icon);
        box.append(boxcontent);

        container.append(box).hide();

        $("#mainLegend").append(container);
        container.fadeIn();
    });
}

/*
*
* Chart.js
*
*
*/
Chart.defaults.global.responsive = true;
Chart.defaults.global.tooltipFontSize = 12;

window.onload = function(){
    var myPie = new Chart(document.getElementById("pie").getContext("2d")).Pie(pieData, {
        animateRotate : false,
        animateScale : true,
        animationEasing: "easeInOutQuint",
        segmentStrokeColor : "#fafafa"
    });

    legend(document.getElementById("mainLegend"), pieData);

    if ($("#chart-play").length > 0) {
        var ctx = document.getElementById("polar-play").getContext("2d");
        window.polarPlay = new Chart(ctx).PolarArea(polarDataPlay, {
            animateRotate : false,
            animateScale : true,
            animationEasing: "easeOutQuint",
            segmentStrokeColor : "#fafafa",
            tooltipTemplate: "<%= value %>",
        });
    }
    if ($("#chart-download").length > 0) {
        var ctx = document.getElementById("polar-down").getContext("2d");
        var polarDown = new Chart(ctx).Doughnut(polarDataDown, {
            animateRotate : true,
            animateScale : false,
            animationEasing: "easeOutQuint",
            segmentStrokeColor : "#fafafa",
            tooltipTemplate: "<%= value %>",
        });
    }

    $("#polar-down").on('click', function(evt){
        var activePoints = polarDown.getSegmentsAtEvent(evt);
        //console.log(activePoints);
        $(".screen-down").html(activePoints[0].label + " <strong>(" + activePoints[0].value + ")</strong>");
        $(".screen-down").css('border-color',activePoints[0].fillColor).css('border-left-width', '20px');
    });

    $("#polar-play").click(function(evt){
        var activePoints = polarPlay.getSegmentsAtEvent(evt);
        //console.log(activePoints);
        $(".screen-play").html(activePoints[0].label + " <strong>(" + activePoints[0].value + ")</strong>");
        $(".screen-play").css('border-color',activePoints[0].fillColor).css('border-left-width', '20px');
    });
}