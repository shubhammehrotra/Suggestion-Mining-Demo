<?php include("inc/header.php");?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked admin-menu " id="list3">
            <li><a><b>Twitter Categories</a></b>
            </li>
            <li><a href="#" id="T1">Twitter 1</a></li>
            <li><a href="#" id="T2">Twitter 2</a></li>
            <li><a href="#" id="T3">Twitter 3</a></li>
            <li><a href="#" id="T4">Twitter 4</a></li>
            <li><a href="#" id="T5">Twitter 5</a></li>
            <li><a href="#" id="T6">Twitter 6</a></li>
        </ul>
    </div>
    <div class="col-md-9 well admin-content">
        <pre id="p3" hidden></pre>
    </div>
    <script>
        $('#list3').on('click', 'li', function () {
            var clicked = $(this).text();
            //alert(clicked);
            $('#p3').show();
            $('#p3').text("Suggestions to be fetched from the api for:  " + clicked);
        });
    </script>
<?php include("inc/footer.php");?>