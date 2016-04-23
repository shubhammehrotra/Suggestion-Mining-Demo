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
    <link rel="stylesheet" type="text/css" href="pre.css">
    <div class="col-md-3">
        <div class="container">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#product">Product Reviews</a></li>
                <li><a data-toggle="tab" href="#hotel">Hotel Reviews</a></li>
            </ul>
            <div class="tab-content">
                <div id="product" class="tab-pane fade in active">
                    <ul class="nav nav-pills nav-stacked admin-menu " id="list1">

                        <li><a href="#" id="Pr1">Nook Ebook Reader</a></li>
                        <li><a href="#" id="P2">Product 2</a></li>
                        <li><a href="#" id="P3">Product 3</a></li>
                        <li><a href="#" id="P4">Product 4</a></li>
                    </ul>
                </div>
                <div id="hotel" class="tab-pane fade">
                    <ul class="nav nav-pills nav-stacked admin-menu " id="list2">
                        <li><a href="#" id="Pr1">Hotel 1</a></li>
                        <li><a href="#" id="P2">Hotel 2</a></li>
                        <li><a href="#" id="P3">Hotel 3</a></li>
                        <li><a href="#" id="P4">Hotel 4</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <br>
    <br>
    <div class="col-md-9 well admin-content" id="outer1" hidden>
     <p style="color:#1D4087;">
            The suggestions are clustered according to the constituent key-phrases. 
      </p>      
      <p style="color:#1D4087;"> Click on a cluster to view the related suggestions. Click again to return to the full view.
            </p>
        <pre id="p1" hidden></pre>
        <br>
        <br>
        <div id="p6" hidden class="col-md-6"></div>
        <pre id="pr6" hidden></pre>
    </div>
    <script>
        // or
        //s = d3.selectAll('svg')

        $('#list1').on('click', 'li', function () {
            $('#outer1').show();
            var s = d3.select("#p6").selectAll('#graphic').remove();
            var clicked = $(this).text();
            check = 1;
            //alert(clicked);
            //$('#p1').show();
            $('#p6').show();
            $('#pr6').hide();
            document.getElementById("p6").innerHTML = "";
            $('#p1').text("Suggestions to be fetched from the api for:  " + clicked);
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
                });

            var svg = d3.select("#p6").append("svg")
                .attr("width", diameter)
                .attr("height", diameter)
                .append("g")
                .attr("transform", "translate(" + diameter / 2 + "," + diameter / 2 + ")")
                .attr("id", "graphic");
            d3.json("flare1.json", function (error, root) {
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
                        var name = d.name;
                        $('#p1').hide();
                        $('#pr6').show();
                        if (focus !== d) zoom(d), d3.event.stopPropagation();
                        var fileName = 'Sentences/Nook/' + d.name + ' Sentence.txt';
                        //alert(fileName);
                        jQuery.get(fileName, function (data) {
                            //alert(data);
                            //process text file line by line
                           // alet
                            //alert(data)
                            //alert(data);
                            $("#pr6").text(data);
                        });
                        //$('#pr6').text("Suggestions to be shown for the topic : " + d.name);
                        
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

                d3.select("body")
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
        $('#list2').on('click', 'li', function () {
            $('#outer1').show();
            var s = d3.select("#p6").selectAll('#graphic').remove();
            var clicked = $(this).text();
            check = 1;
            //alert(clicked);
            //$('#p1').show();
            $('#p6').show();
            $('#pr6').hide();
            document.getElementById("p6").innerHTML = "";
            $('#p1').text("Suggestions to be fetched from the api for:  " + clicked);
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

            var svg = d3.select("#p6").append("svg")
                .attr("width", diameter)
                .attr("height", diameter)
                .append("g")
                .attr("transform", "translate(" + diameter / 2 + "," + diameter / 2 + ")")
                .attr("id", "graphic");
            d3.json("flare1.json", function (error, root) {
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
                        $('#p1').hide();
                        $('#pr6').show();
                        if (focus !== d) zoom(d), d3.event.stopPropagation();
                        var jsonUrl1 = "enter server address here" + d.name + " Sentence.txt";
                        $.ajax({
                            type: 'GET',
                            url: "inc/get.php",
                            data: {
                                "url": jsonUrl1
                            },
                            success: function (response) {
                                // Showing the result after using REGEX to clean it
                                if (response == "") {
                                    $('#pr6').text("Sorry !");
                                } else {
                                    $('#pr6').text(response);
                                }
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                // Showing an error message if an error occured
                                $('#pr6').text(errorThrown);
                            }
                        });
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

                d3.select("body")
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