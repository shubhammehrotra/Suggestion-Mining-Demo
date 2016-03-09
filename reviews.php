<?php include("inc/header.php");?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked admin-menu " id="list1">
            <li><a><b>Product Categories</a></b>
            </li>
            <li><a href="#" id="P1">Product 1</a></li>
            <li><a href="#" id="P2">Product 2</a></li>
            <li><a href="#" id="P3">Product 3</a></li>
            <li><a href="#" id="P4">Product 4</a></li>
            <li><a href="#" id="P5">Product 5</a></li>
            <li><a href="#" id="P6">Product 6</a></li>
        </ul>
    </div>
    <div class="col-md-9 well admin-content">
        <pre id="p1" hidden></pre>
    </div>
    <script>
        $('#list1').on('click', 'li', function () {
            var clicked = $(this).text();
            //alert(clicked);
            $('#p1').show();
            $('#p1').text("Suggestions to be fetched from the api for:  " + clicked);
        });
    </script>
<?php include("inc/footer.php");?>