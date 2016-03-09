<?php include("inc/header.php");?>
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
    <div class="col-md-9 well admin-content">
        <pre id="p2" hidden></pre>
    </div>
    <script>
        $('#list2').on('click', 'li', function () {
            var clicked = $(this).text();
            //alert(clicked);
            $('#p2').show();
            $('#p2').text("Suggestions to be fetched from the api for:  " + clicked);
        });
    </script>
<?php include("inc/footer.php");?>