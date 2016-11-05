<html>
    <head>
        <title>Final Project: Team 11</title>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <style>
            table, th, td {
                border: 1px solid black;
                margin-left: auto;
                margin-right: auto;
                text-align: center;
            }
            
            th, td {
                padding: 5px;
            }
            h1 {
                text-align: center;
            }
            
            h3 {
                text-align: center;
            }
            
            p {
                text-align: center;
            }
            
            body {
                font-family: 'Open Sans';
                background-color: lightblue;
            }
            div {
                display: block;
                border: 5px solid black;
                margin: auto;
                padding: 10px;
            }
            .docInfo {
                text-align: left;
            }
        
        </style>

    </head>


<body>

<?php

// connect to database...
$dbcon = mysqli_connect("db.soic.indiana.edu", "i308m16_team11", "my+sql=i308m16_team11", "i308m16_team11");

    
// Check Connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL:" .mysqli_connect_error();

}
    
///////////////// Query 1  /////////////////
    
    
if (!empty($_POST['query1'])) {
    // QUERY 1 PROCESSING
    $class = mysqli_real_escape_string($dbcon, $_POST['class1']);
    $sql = "(SELECT s.fname as FirstName, s.lname as LastName
    FROM Student as s, StudentsTakingClasses as stc
    WHERE stc.CNUM = '$class'
    and s.SID = stc.SID
    GROUP BY s.SID
    ORDER BY s.lname ASC, s.fname)
    union all
    (select 'Average GPA',ROUND(AVG(stc.gpa),2) as GPA
    from StudentsTakingClasses as stc
    where stc.CNUM = '$class')";
    
    $result = mysqli_query($dbcon, $sql);
    $num_rows = mysqli_num_rows($result);
    
    if ($result->num_rows > 0) {
        
        echo "<h2>Query 1B Results</h2><br>";
        echo "<h3>Feature Selected: $class</h3>";
        
        echo "<table><tr><th>FirstName</th><th>LastName</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            
            echo "<tr><td>".$row["FirstName"]."</td><td>".$row["LastName"]."</td></tr>";
            
        }
        echo "</table>";
    } else {
        echo "<h3>0 Results.</h3>";
    }
    
    echo "<br><br>";
    echo "<p>$num_rows Row(s)</p>";
    // Close connection
    mysqli_close($dbcon);   
        
    }



if (!empty($_POST['query2'])) {
    // QUERY 2B PROCESSING
    $feature = mysqli_real_escape_string($dbcon, $_POST['feature']);
    
    $sql = "select distinct r.RID as RID, r.roomType as roomType, r.buildingName as buildingName
    from Room as r, RoomFeatures as rf, Class as c
    where c.RID = r.RID
    and r.RID = rf.RID
    and rf.feature = '$feature'
    and '12:15:00' between c.startTime and c.endTime";
    
    $result = mysqli_query($dbcon, $sql);
    
    $num_rows = mysqli_num_rows($result);
    
    if ($result->num_rows > 0) {
        
        echo "<h2>Query 2B Results</h2><br>";
        echo "<h3>Feature Selected: $feature</h3>";
        
        echo "<table><tr><th>RID</th><th>roomType</th><th>buildingName</th></tr>";
        
        // output each row...
        while ($row = $result->fetch_assoc()) {
            
            echo "<tr><td>".$row["RID"]."</td><td>".$row["roomType"]."</td><td>".$row["buildingName"]."</td></tr>";
            
        }
        echo "</table>";
    } else {
        echo "<h3>0 Results.</h3>";
    }
    
    echo "<p>$num_rows Row(s)</p>";
    
    // Close connection
    mysqli_close($dbcon);
        
    }
    
if (!empty($_POST['query3'])) {
    // QUERY 3B PROCESSING
    
    $class = mysqli_real_escape_string($dbcon, $_POST['class2']);
    
    $sql = "SELECT f.FID as FID, concat(f.fName, ' ', f.lName) as name
    FROM Faculty as f
    WHERE f.FID NOT IN
    (SELECT DISTINCT f.FID
    FROM Class as c
    WHERE c.FID = f.FID
    AND c.CNUM = '$class')";
   
    $result = mysqli_query($dbcon, $sql);
    
    $num_rows = mysqli_num_rows($result);
    
    if ($result->num_rows > 0) {
        
        echo "<h2>Query 3B Results</h2><br>";
        
        echo "<table><tr><th>FID</th><th>name</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            
            echo "<tr><td>".$row["FID"]."</td><td>".$row["name"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<h3>0 Results</h3>";
    }
    
    echo "<br><br>";
    echo "<p>$num_rows Row(s)</p>";
    // Close connection
    mysqli_close($dbcon);
    
}
    
if (!empty($_POST['query4'])) {
    // QUERY 4B PROCESSING
    
    $class = mysqli_real_escape_string($dbcon, $_POST['class3']);

    $sql = "SELECT DISTINCT concat(s.fname,' ',s.lname) as name
    FROM Student as s, Course as c, CoursePreq as cp, StudentsTakingClasses as stc
    WHERE s.SID =stc.SID
    AND stc.CNUM = c.CNUM
    AND c.CNUM = cp.coursePreq
    AND cp.CNUM = '$class'
    AND stc.SID NOT IN (
    SELECT stc.SID
    FROM StudentsTakingClasses as stc
    WHERE stc.CNUM = '$class')";
    
    $result = mysqli_query($dbcon, $sql);
    $num_rows = mysqli_num_rows($result);
    
    if ($result->num_rows > 0) {
        
        echo "<h2>Query 4B Results</h2><br>";
        
        echo "<table><tr><th>name</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            
            echo "<tr><td>".$row['name']."</td></tr>";
            
        }
        echo "</table>";
    } else {
        echo "<h3>0 Results</h3>";
    }
    
    echo "<br><br>";
    echo "<p>$num_rows Row(s)</p>";
    // Close connection
    mysqli_close($dbcon);
        
    }
    
if (!empty($_POST['query6'])) {
    // QUERY 6C
    
    $building = mysqli_real_escape_string($dbcon, $_POST['building']);
    $time = mysqli_real_escape_string($dbcon, $_POST['time']);

    $sql = "select distinct s.SID as SID, concat(s.fName, ' ', s.lName) as studentName, f.FID as FID, f.rank as rank, a.AID as AID, concat(a.fName, ' ', a.lName) as advisorName, r.buildingName as buildingName, r.roomType as roomType
    from Student as s, Faculty as f, Room as r, Class as c, StudentsTakingClasses as stc, Advisor as a
    where s.SID = stc.SID
    and stc.CNUM = c.CNUM
    and a.RID = r.RID
    and f.FID = c.FID
    and c.RID = r.RID
    and (r.buildingName = '$building' or ('12:15:00' not between c.startTime and c.endTime) or r.roomType = 'Office')";
    
    $result = mysqli_query($dbcon, $sql);
    $num_rows = mysqli_num_rows($result);
    
    if ($result->num_rows > 0) {
        
        echo "<h2>Query 6C Results</h2><br>";
        
        echo "<table><tr><th>SID</th><th>studentName</th><th>FID</th><th>rank</th><th>AID</th><th>advisorName</th><th>buildingName</th><th>roomType</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            
            echo "<tr><td>".$row['SID']."</td><td>".$row['studentName']."</td><td>".$row['FID']."</td><td>".$row['rank']."</td><td>".$row['AID']."</td><td>".$row['advisorName']."</td><td>".$row['buildingName']."</td><td>".$row['roomType']."</td></tr>";
            
        }
        echo "</table>";
    } else {
        echo "<h3>0 Results</h3>";
    }
    echo "<br><br>";
    echo "<p>$num_rows Row(s)</p>";
    // Close connection
    mysqli_close($dbcon);
        
    }
    
if (!empty($_POST['query7'])) {
    // QUERY 7A
    
    $advisor = mysqli_real_escape_string($dbcon, $_POST['advisor']);
    
    $sql = "SELECT DISTINCT s.lname as lname, s.fname as fname, m.title as title
    FROM Student as s, AdviseStudent as a, Major as m, StudentMajor as sm
    WHERE s.SID = a.SID
    AND sm.SID = s.SID
    AND m.MID = sm.MID
    AND a.AID = $advisor
    ORDER BY s.lname, s.fname";
        
    $result = mysqli_query($dbcon, $sql);
    $num_rows = mysqli_num_rows($result);
    
    if ($result->num_rows > 0) {
        
        echo "<h2>Query 7A Results</h2><br>";
        
        echo "<table><tr><th>lname</th><th>fname</th><th>title</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            
            echo "<tr><td>".$row['lname']."</td><td>".$row['fname']."</td><td>".$row['title']."</td></tr>";
            
        }
        echo "</table>";
    } else {
        echo "<h3>0 Results</h3>";
    }
    echo "<br><br>";
    echo "<p>$num_rows Row(s)</p>";
    // Close connection
    mysqli_close($dbcon);    
        
    }
    
if (!empty($_POST['aquery1'])) {
    // ADDITIONAL QUERY 1
    
    $sql = "SELECT DISTINCT c.CNUM as CNUM, c.title as title, COUNT(cl.CNUM) as courseCount
    FROM Class as cl, Course as c
    WHERE c.CNUM = cl.CNUM
    AND c.CNUM = 'I-300'";
    
    $result = mysqli_query($dbcon, $sql);
    $num_rows = mysqli_num_rows($result);
    
    if ($result->num_rows > 0) {
        
        echo "<h2>Additional Query 1 Results</h2><br>";
        
        echo "<table><tr><th>CNUM</th><th>title</th><th>courseCount</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            
            echo "<tr><td>".$row['CNUM']."</td><td>".$row['title']."</td><td>".$row['courseCount']."</td></tr>";
            
        }
        echo "</table>";
    } else {
        echo "<h3>0 Results</h3>";
    }
    echo "<br><br>";
    echo "<p>$num_rows Row(s)</p>";
    // Close connection
    mysqli_close($dbcon);
        
    }
    
if (!empty($_POST['aquery2'])) {
    // ADDITIONAL QUERY 2
    
    $sql = "select AVG(stc.gpa) as AverageGPA, m.title as Major
    from StudentsTakingClasses as stc, Major as m, StudentMajor as sm
    where stc.SID = sm.SID
    and sm.MID = m.MID
    group by Major
    order by AverageGPA desc";
    
    $result = mysqli_query($dbcon, $sql);
    $num_rows = mysqli_num_rows($result);
    
    if ($result->num_rows > 0) {
        
        echo "<h2>Additional Query 2 Results</h2><br>";
        
        echo "<table><tr><th>AverageGPA</th><th>Major</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            
            echo "<tr><td>".$row['AverageGPA']."</td><td>".$row['Major']."</td></tr>";
            
        }
        echo "</table>";
    } else {
        echo "<h3>0 Results</h3>";
    }
    echo "<br><br>";
    echo "<p>$num_rows Row(s)</p>";
    //Close connection
    mysqli_close($dbcon);
        
    }

?>

    </body>
</html>