<?php include("inc/header.php");?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked admin-menu ">
            <li><a><b>Suggestion Extraction Techniques</a></b>
            </li>
            <li><a href="index.php" data-target-id="SVM">Support Vector Machines</a></li>
            <li><a href="#" data-target-id="NN">Deep Learning</a></li>
            <li class="active"><a href="RuleBased.php" data-target-id="RB">Rule Based</a></li>
        </ul>
    </div>
    <div class="col-md-9 well admin-content" id="RB">
        <p>
            Please enter text in the space provided below :
        </p>

        <div class="row">

            <form id="theForm1" onsubmit="event.preventDefault();" enctype="text/plain">
                <div class="col-sm-9">
                    <textarea class="form-control" rows="5" id="mainText1" value name = "text" type = "text">This is a fabulous hotel. The breakfasts are great - fresh fruit  bagels, muffins, hot eggs and sausage etc. Just around the corner from the hotel is a fabulous little Italian restaurant - Bon Amici. I highly recommend it.</textarea>
                    <!--<input id="mainText1" name="text" type="text" class="form-control" value="This is a fabulous hotel. The breakfasts are great - fresh fruit  bagels, muffins, hot eggs and sausage etc. Just around the corner from the hotel is a fabulous little Italian restaurant - Bon Amici. I highly recommend it. ">
                    <input id="mainText2" name="text" type="hidden" class="form-control" placeholder="Select the Language and Text Source for Suggestion Extraction" autofocus="autofocus">-->
                </div>
                <div class="row">
                    <div class="col-sm-1">
                        <select class="language-select" name="language" label="Language">
                            <option value="en" selected>English</option>
                            <!--<option value="es">Spanish</option>
                            <option value="fr">French</option>
                            <option value="it">Italian</option>-->
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <select class="language-select" name="textSource">
                            <option value="ge" selected>General</option>
                            <option value="tw">Twitter</option>
                        </select>
                    </div>
                </div>

        </div>
        <br>
        <div class="text-center">
            <button type="submit" id="sendJson1" class="btn btn-primary btn-md pull-left">Extract</button>
            <img src="images/Spinner.svg" id="image" hidden>
            <br>
            <br>
        </div>
        <pre id="result" hidden></pre>
        </form>
    </div>
    <!-- jQuery Version 1.11.1 -->
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

    <script language="javascript" type="text/javascript">
        // Here you send & receive the data
        $(function () {

            $('#theForm1').submit(function () {
                // First we get the JSON collected from the form
                $("#result").hide();
                var jsonValue = document.getElementById('mainText1').value;
                $("#image").show();
                $("#sendJson1").hide();
                // We form the request url
                var jsonUrl1 = "http://localhost:8080/RuleBasedSuggestionClassifier/webapi/check/" + encodeURIComponent(jsonValue)
                $.ajax({
                    type: 'GET',
                    url: "inc/get.php",
                    data: {
                        "url": jsonUrl1
                    },
                    success: function (response) {
                        // Showing the result after using REGEX to clean it
                        $("#image").hide();
                        if (response == "") {
                            $('#result').text("No Suggestions found !");
                        } else {
                            //$('#result').text(response.replace(/[^\w\s\',']/gi, '').replace(/[',']/g,'.\n'));

                            $('#result').text(response);
                        }
                        $('#result').show();
                        $('#sendJson1').show();
                        document.getElementById("mainText1").value = '';


                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        // Showing an error message if an error occured
                        $('#result').text(errorThrown);
                    }
                });

                // please don't remove the return false
                return false;
            });
        });
    </script>
    </div>
    <div class="row">

        <div class="col-md-12 ">
            <br>
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b>Suggestion Mining from Opinions</b></h3>
                </div>
                <div class="panel-body">
                    <p>
                         This is a demonstrator for the research on Suggestion Mining carried out at the <a href="http://nlp.insight-centre.org/" target="_blank">Unit for Natural Language Processing, at the Insight Centre for Data Analytics ,Galway</a>. Suggestion Mining deals with the extraction of suggestion carrying sentences from any given text, mainly the opinionated text across different platforms like online reviews, discussion forums, tweets, political debates etc. After the suggestions sentences are extracted, a semantic analysis is performed for the themes present in those suggestions.


                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php include("inc/footer.php");?>