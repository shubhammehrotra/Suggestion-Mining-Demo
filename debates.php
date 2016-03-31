<?php include("inc/header.php");?>
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
    <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked admin-menu " id="list2">
            <li><a><b>Debate Categories</a></b>
            </li>
            <li><a href="#" id="D1">Debate 1</a></li>
            <li><a href="#" id="D2">Debate 2</a></li>
            <li><a href="#" id="D3">Debate 3</a></li>
            <li><a href="#" id="D4">Debate 4</a></li>
            <li><a href="#" id="D5">Debate 5</a></li>
            <li><a href="#" id="D6">Debate 6</a></li>
        </ul>
    </div>
    <div class="col-md-9 well admin-content" id="outer2" hidden>
        <pre id="p2" hidden></pre>
        <br>
        <br>
        <div id="p5" hidden class=c ol-md-6></div>
        <pre id="pr5" hidden></pre>
    </div>
    <script>
        // or
        //s = d3.selectAll('svg')

        $('#list2').on('click', 'li', function () {
            $('#outer2').show();
            var s = d3.select("#p5").selectAll('#graphic').remove();
            var clicked = $(this).text();
            check = 1;
            var z;
            $('#p2').show();
            $('#p5').show();
            document.getElementById("p5").innerHTML = "";
            $('#pr5').hide();
            $('#p2').text("Suggestions to be fetched from the api for the topic:  " + clicked);

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

            var svg = d3.select("#p5").append("svg")
                .attr("width", diameter)
                .attr("height", diameter)
                .append("g")
                .attr("transform", "translate(" + diameter / 2 + "," + diameter / 2 + ")")
                .attr("id", "graphic");
            d3.json("flare.json", function (error, root) {
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
                        var z = d.name;
                        $('#p2').hide();
                        $('#pr5').show();
                        $('#pr5').text("Suggestions to be shown for the topic : " + z);
                        console.log(d.name);
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

                d3.select("#p5")
                    .on("click", function () {
                        //console.log(root.children.name);
                        zoom(root);

                    });

                zoomTo([root.x, root.y, root.r * 2 /*+ margin*/ ]);

                function zoom(d) {
                    var focus0 = focus;
                    focus = d;
                    //alert(d.name);
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
                            //alert(d.name);
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
                        //alert(d.name);
                        //console.log(d.name);
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