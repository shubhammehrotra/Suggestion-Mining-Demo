<?php include("inc/header.php");?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b>Rest API</b></h3>
                </div>
                <div class="panel-body">
                    <ul>
                     <li> API call for our deep learning based (best performing) suggestion detector: 
                        <pre> http://140.203.155.226:8080/miso/rest/suggest/getSuggestions?json=</pre>
                        </li>
                        
                        <li><b>Input:</b> 
                            <br>
                            The API accepts input in a json format. It has three fields, which represent the input text, 
                            source of the text ("twitter" or "general"), and the language (only "en" currently)
                            . Example of json input:
                                                <pre>
{
    "text": 
        "This is a fabulous hotel. The breakfasts are great - fresh fruit bagels, muffins, hot eggs and sausage etc. 
        Just around the corner from the hotel is a fabulous little Italian restaurant - Bon Amici, I highly recommend it.",
    "textSource": "general",
        "language": "en"
        }
}
</pre>                
</li>
<li><b>Output:</b> 
                            <br>
                    
                    The output json provides an array of sentences which are detected as suggestions. 
                    Example of output json:
                    <pre>
{
    "result": [
        "Just around the corner from the hotel is a fabulous little Italian restaurant - Bon Amici, I highly recommend it.",
    ]
}
</pre>
</li>
                    </ul>


                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->

    <?php include("inc/footer.php");?>