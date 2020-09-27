<!DOCTYPE html>
<html>
    <head>
        <!-- Load D3 from site -->
        <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>

        <!-- CSS (Styling) -->
        <style type="text/css">

        body {
            margin: 0;
            font-family: sans-serif;
            font-size: 11px;
        }

        .axis path, .axis line {
            fill: none;
            stroke: black;
            shape-rendering: crispEdges;  /* Round any decimal pixels so it'll render nicely */
        }

        /*
        * //Can use CSS3 Transitions, but not for everything (e.g. change radius size)
        *   circle:hover{
        *       fill: green;
        *   }
        */

        </style>
    </head>
    <body>
        <!-- Begin Javascript -->
        <script type="text/javascript">
            var w = window.innerWidth,
                h = window.innerHeight,
                margin = { top: 40, right: 20, bottom: 20, left: 40 },
                radius = 40;

            var svg = d3.select("body").append("svg").attr({
                width: w,
                height: h
            });

            var dataset = [
                { x: 50, y: 50 },
            ];

            //We're passing in a function in d3.max to tell it what we're maxing (x value)
            var xScale = d3.scale.linear()
                .domain([0, d3.max(dataset, function (d) { return d.x + 10; })])
                .range([margin.left, w - margin.right]);  // Set margins for x specific

            // We're passing in a function in d3.max to tell it what we're maxing (y value)
            var yScale = d3.scale.linear()
                .domain([0, d3.max(dataset, function (d) { return d.y + 10; })])
                .range([margin.top, h - margin.bottom]);  // Set margins for y specific

            var circleAttrs = {
                cx: function(d) { return xScale(d.x); },
                cy: function(d) { return yScale(d.y); },
                r: radius
            };

            svg.selectAll("circle")
                .data(dataset)
                .enter()
                .append("circle")
                .attr(circleAttrs)  // Get attributes from circleAttrs var
                .on("mouseover", handleMouseOver)
                .on("mouseout", handleMouseOut);

            // On Click, we want to add data to the array and chart
            svg.on("click", function() {
                var coords = d3.mouse(this);

                // Normally we go from data to pixels, but here we're doing pixels to data
                var newData= {
                    x: Math.round( xScale.invert(coords[0])),  // Takes the pixel number to convert to number
                    y: Math.round( yScale.invert(coords[1]))
                };

                dataset.push(newData);   // Push data to our array

                svg.selectAll("circle")  // For new circle, go through the update process
                    .data(dataset)
                    .enter()
                    .append("circle")
                    .attr(circleAttrs)  // Get attributes from circleAttrs var
                    .on("mouseover", handleMouseOver)
                    .on("mouseout", handleMouseOut);
            })

            let name= "ryyn bow"

            // Create Event Handlers for mouse
            function handleMouseOver(d, i) {  // Add interactivity
                // Use D3 to select element, change color and size
                d3.select(this).attr({
                    fill: "orange",
                    r: radius
                });

                /* svg.append("image") */
                /*     .attr("xlink:href", "https://via.placeholder.com/40.png") */
                /*     .attr("x", xScale(d.x)) */
                /*     .attr("y", yScale(d.y)) */
                /*     .attr("width", 40) */
                /*     .attr("height", 40); */
            }

            function handleMouseOut(d, i) {
                // Use D3 to select element, change color back to normal
                d3.select(this).attr({
                    fill: "black",
                    r: radius
                });

                // Select text by id and then remove
                d3.select("#t" + d.x + "-" + d.y + "-" + i).remove();  // Remove text location

                // Specify where to put label of text
                svg.append("text").attr({
                    id: "t" + d.x + "-" + d.y + "-" + i,  // Create an id for text so we can select it later for removing on mouseout
                    x: function() { return xScale(d.x) - 22; },
                    y: function() { return yScale(d.y) + 55; }
                })
                .text(function() {
                    return [name];  // Value of the text
                });
            }
        </script>
    </body>
</html>