<html>
    <head>
        <title>COMP4711 XML Lab Simple</title>
    </head>
    <form method="post" name="values">
        <table>
        <tr>
            <td>Days</td>
            <td>Courses</td>
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
    </form>
    
</html>
