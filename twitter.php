<?php include("inc/header.php");?>
    <script>
        var check = 0;
    </script>
    <style>
        .node {
            cursor: pointer;
        }
        
        .node:hover {
            stroke: #000;
            stroke-width: 1.5px;
        }
        
        .node--leaf {
            fill: white;
        }
        
        .label {
            font: 11px "Helvetica Neue", Helvetica, Arial, sans-serif;
            text-anchor: middle;
            text-shadow: 0 1px 0 #fff, 1px 0 0 #fff, -1px 0 0 #fff, 0 -1px 0 #fff;
        }
        
        .label,
        .node--root,
        .node--leaf {
            pointer-events: none;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="pre.css">
    <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked admin-menu " id="list3">
            <li><a><b>Politicians' Twitter Handles</a></b>
            </li>
            <li><a href="#" id="T1">Susan O'Keeffe (@susanokeeffe)</a></li>
            <li><a href="#" id="T2">MaryMitchellO'Connor (@mitchelloconnor)</a></li>
            <li><a href="#" id="T3">Michael Mc Carthy (@mmccarthy_mc)</a></li>
            <li><a href="#" id="T4">Ciara Conway (@ciaramconway)</a></li>
            <li><a href="#" id="T5">Ciaran Cannon (@ciarancannon)</a></li>
            <li><a href="#" id="T6">Regina Doherty TD (@ReginaDo) </a></li>
        </ul>
    </div>
    <br>
    <br>
    <div class="col-md-9 well admin-content" id="outer3" hidden>
        <p style="color:#1D4087;">
            The suggestions are clustered according to the constituent key-phrases.
        </p>
        <p style="color:#1D4087;"> Click on a cluster to view the related suggestions. Click again to return to the full view.
        </p>
        <pre id="p3" hidden></pre>
        <br>
        <br>
        <div id="p4" hidden class="col-md-6"></div>
        <pre id="pr4" hidden></pre>
    </div>
    <script>
        // or
        //s = d3.selectAll('svg')

        $('#list3').on('click', 'li', function () {
            $('#outer3').show();
            var s = d3.select("#p4").selectAll('#graphic').remove();
            var clicked = $(this).text();
            check = 1;
            //alert(clicked);
            // $('#p3').show();
            $('#p4').show();
            document.getElementById("p4").innerHTML = "";
            $('#pr4').hide();
            $('#p3').text("Suggestions to be fetched from the api for:  " + clicked);

            var margin = 0,
                diameter = 400;

            var color = d3.scale.linear()
                .domain([-1, 5])
                .range(["hsl(152,80%,80%)", "hsl(228,30%,40%)"])
                .interpolate(d3.interpolateHcl);

            var pack = d3.layout.pack()
                .padding(2)
                .size([diameter - margin, diameter - margin])
                .value(function (d) {
                    return d.size;
                })

            var svg = d3.select("#p4").append("svg")
                .attr("width", diameter)
                .attr("height", diameter)
                .append("g")
                .attr("transform", "translate(" + diameter / 2 + "," + diameter / 2 + ")")
                .attr("id", "graphic");
            d3.json("flare3.json", function (error, root) {
                if (error) throw error;

                var focus = root,
                    nodes = pack.nodes(root),
                    view;

                var circle = svg.selectAll("circle")
                    .data(nodes)
                    .enter().append("circle")
                    .attr("class", function (d) {
                        return d.parent ? d.children ? "node" : "node node--leaf" : "node node--root";
                    })
                    .style("fill", function (d) {
                        return d.children ? color(4.3) : null;
                    })
                    .on("click", function (d) {
                        $('#p3').hide();
                        $('#pr4').show();
                        //$('#pr4').text("Suggestions to be shown for topic: " + d.name);
                        var fileName = 'Sentences/Tweets/' + d.name + ' Sentence.txt';
                        jQuery.get(fileName, function (data) {
                            //alert(data);
                            //process text file line by line
                            // alet
                            //alert(data)
                            //alert(data);
                            $("#pr4").text(data);
                        });
                        if (focus !== d) zoom(d), d3.event.stopPropagation();
                    });

                var text = svg.selectAll("text")
                    .data(nodes)
                    .enter().append("text")
                    .attr("class", "label")
                    .style("fill-opacity", function (d) {
                        return d.parent === root ? 1 : 0;
                    })
                    .style("display", function (d) {
                        return d.parent === root ? "inline" : "none";
                    })
                    .text(function (d) {
                        return d.name;
                    });

                var node = svg.selectAll("circle,text");

                d3.select("#p4")
                    .on("click", function () {
                        zoom(root);
                    });

                zoomTo([root.x, root.y, root.r * 2 /*+ margin*/ ]);

                function zoom(d) {
                    var focus0 = focus;
                    focus = d;

                    var transition = d3.transition()
                        .duration(d3.event.altKey ? 7500 : 750)
                        .tween("zoom", function (d) {
                            var i = d3.interpolateZoom(view, [focus.x, focus.y, focus.r * 2 /*+ margin*/ ]);
                            return function (t) {
                                zoomTo(i(t));
                            };
                        });

                    transition.selectAll("text")
                        .filter(function (d) {
                            return d.parent === focus || this.style.display === "inline";
                        })
                        .style("fill-opacity", function (d) {
                            return d.parent === focus ? 1 : 0;
                        })
                        .each("start", function (d) {
                            if (d.parent === focus) this.style.display = "inline";
                        })
                        .each("end", function (d) {
                            if (d.parent !== focus) this.style.display = "none";
                        });
                }

                function zoomTo(v) {
                    var k = diameter / v[2];
                    view = v;
                    node.attr("transform", function (d) {
                        return "translate(" + (d.x - v[0]) * k + "," + (d.y - v[1]) * k + ")";
                    });
                    circle.attr("r", function (d) {
                        return d.r * k;
                    });
                }
            });
            /*var active = graphic.active ? false : true,
                newOpacity = active ? 0 : 1;
            d3.select("#graphic").style("opacity", newOpacity);
            graphic.active = active;*/
            //$('#p4').hide();
        });
    </script>
    <script src="//d3js.org/d3.v3.min.js"></script>
    <?php include("inc/footer.php");?>