<?php include("inc/header.php");?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b>Rest API(EnRG) To be changed</b></h3>
                </div>
                <div class="panel-body">
                    <p><i>Using the API:</i></p>
                    <p>To use the API you must:</p>
                    <ul>
                        <li><b>Input: </b>append the json call and entity parameter (Wikipedia Link or Wikipedia label for the entity) to the endpoint as follows:
                            <br>
                            <pre> http://monnet01.sindice.net:8080/enrg/api/enrg/json?entity=</pre>
                        </li>
                        <li><b>Input:</b> appending the entity value as the example below:
                            <br> add Wikipedia Link http://en.wikipedia.org/wiki/Brad_Pitt for Brad Pitt:
                            <br>
                            <pre>http://monnet01.sindice.net:8080/enrg/api/enrg/json?entity=http://en.wikipedia.org/wiki/Brad_Pitt</pre> add Wikipedia Label Brad_Pitt for Brad Pitt:
                            <br>
                            <pre>http://monnet01.sindice.net:8080/enrg/api/enrg/json?entity=Brad_Pitt</pre>
                        </li>
                        <li><b>Output: </b>Get the results in a json format:
                            <br> It includes several ranked lists of entities for different types of entities. For every entity type e.g. Place and Other Concepts as in the example shown below, json would contain a Json list of entity pairs containing the relatedness scores in each.
                        </li>
                    </ul>

                    <h4>Example as follows:</h4>
                    <pre>
{
    "http://dbpedia.org/ontology/Place": [
        {"http://dbpedia.org/resource/Ouarzazate":10.3109364745519},
        {"http://dbpedia.org/resource/Cinema_of_the_United_States ":5.60468931340941},
        {"http://dbpedia.org/resource/East_Ayrshire":5.32881528327248},
        {"http://dbpedia.org/resource/Paradise,_Nevada":5.16277001359725},
        {"http://dbpedia.org/resource/New_Orleans":5.05640134500144}
    ],
    "http://dbpedia.org/ontology/Other Concepts": [
        {"http://dbpedia.org/resource/Academy_Award_for_Best_Actor":22.2152593507837},
        {"http://dbpedia.org/resource/Deadline.com":20.6511115302264}
    ]
}
</pre>

                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->

    <?php include("inc/footer.php");?>