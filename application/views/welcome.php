<html>
    <head>
        <title>COMP4711 XML Lab Simple</title>
        <!--latest compiled and minified bootstrap css -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">

        <!-- JQuery source - MUST be loaded before bootstrap js -->
        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script> 

        <!-- Latest compiled and minified bootstrap js -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
 
        <!-- Our stylesheet -->
        <link rel="stylesheet" type="text/css" media="all" href="../assets/styles.css" />
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <div class="container-fluid">
                    <nav class="navbar navbar-inverse">
                        <h1 class="navbar-brand">Student Schedule</h1>
                    </nav>
                </div>
            </div>
            <form method="post" name="values">
                <table>
                    <tr>
                        <td>Courses</td>
                        <td>Days</td>
                        <td>Time</td>
                    </tr>
                    <tr>
                        <td>
                            <select name="Courses">
                                {coursedropdown}
                            </select>
                        </td>
                        <td>
                            <select name="Days">
                                {daydropdown}
                            </select>
                        </td>
                        <td>
                            <select name="Times">
                                {timedropdown}
                            </select>
                        </td>
                        <td>
                            <input type="submit">
                        </td>
                    </tr>
                </table>
            </form>
            <div id="content">
                <div>
                    <h2>Bingo was {bingo_found}</h2>
                    {bingo_results}
                </div>
                <div class="table-responsive">
                    <h3> Course Results </h3>
                    {course_result_table}
                </div>
                <div class="table-responsive">
                    <h3> Day Results </h3>
                    {day_result_table}
                </div>
                <div class="table-responsive">
                    <h3> Time Results </h3>
                    {time_result_table}
                </div>
            </div>
        </div>
    </body>
</html>
