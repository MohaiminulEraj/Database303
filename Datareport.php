<?php



use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;


class Datareport extends \koolreport\KoolReport
{
    use \koolreport\clients\Bootstrap; //for adding style to report
    //Create Settings
    protected function settings()
    {
        return array(
            "dataSources"=>array(
                "database303"=>array(
                    "connectionString"=>"mysql:host=localhost;dbname=database303",
                    "username"=>"root",
                    "password"=>"",
                    "charset"=>"utfa"
                )
            )
        );
    }

    //Setup report
    protected function setup()
    {
        if(!isset($_POST['submit'])){
        header("Location: chart.php");
    }

    $focus =$_POST['focus'];
    $start = $_POST['start'];
    $end = $_POST['end'];


        $this->src("database303")                 //MG
        ->query("
            SELECT tb1.year, tb1.Spring, tb2.Summer, tb3.Autumn, sum(tb1.Spring+tb2.Summer+tb3.Autumn) as 'Grand Total'
            FROM
            (SELECT e.year, SUM(em.noOfStudent) AS Spring
            FROM tbl_exam_major em, tbl_exam e
            WHERE e.year=em.year AND e.semester ='Spring' AND e.semester=em.semester AND e.slot=em.slot AND em.year >= '$start' AND em.year <= '$end'
            GROUP BY e.year) as tb1,
            (SELECT e.year, SUM(em.noOfStudent) AS SUMMER
            FROM tbl_exam_major em, tbl_exam e
            WHERE e.year=em.year AND e.semester ='SUMMER' AND e.semester=em.semester AND em.year >= '$start' AND em.year <= '$end'
            GROUP BY e.year) as tb2,
            (SELECT e.year, SUM(em.noOfStudent) AS AUTUMN
            FROM tbl_exam_major em, tbl_exam e
            WHERE e.year=em.year AND e.semester ='Autumn' AND e.semester=em.semester AND em.year >= '$start' AND em.year <='$end'
            GROUP BY e.year) as tb3


            WHERE tb1.year = tb2.year AND tb2.year = tb3.year
            GROUP BY tb1.year

        ")
        ->pipe($this->dataStore("result"));

        $this->src("database303")                 //ME
        ->query("
            SELECT em.semester,SUM(em.noOfStudent) AS TotalStd
            FROM tbl_exam_major em, tbl_exam e, (SELECT SUM(em.noOfStudent) AS T FROM tbl_exam_major em WHERE em.year='$focus') AS K
            WHERE em.year=e.year AND em.semester=e.semester AND
            em.slot=e.slot AND em.year='$focus'
            GROUP BY em.semester

        ")
        ->pipe($this->dataStore("result1"));

        $this->src("database303")                 //MG
        ->query("
            SELECT em.year, SUM(em.noOfStudent) AS 'No of Student'
            FROM tbl_exam_major em
            WHERE em.year >= '$start' AND em.year <= '$end'
            GROUP BY em.year


        ")
        ->pipe($this->dataStore("result2"));

        $this->src("database303")                 //MG
        ->query("
            SELECT tb1.year, tb1.SOB, tb2.SECS, tb3.OtherSchools
            FROM (SELECT em.year, SUM(em.noOfStudent) AS SOB
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>= '$start' AND em.year<='$end' AND s.schoolID='IUB_SHSOB'
            GROUP BY em.year) as tb1,
            (SELECT em.year, SUM(em.noOfStudent) AS SECS
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>= '$start' AND em.year<='$end' AND s.schoolID='IUB_SHSECS'
            GROUP BY em.year) as tb2, (SELECT em.year, SUM(em.noOfStudent) AS OtherSchools
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>= '$start' AND em.year<='$end' AND s.schoolID!='IUB_SHSECS' AND s.schoolID!='IUB_SHSOB'
            GROUP BY em.year) as tb3, tbl_exam_major eem
            where tb1.year = tb2.year and tb2.year = tb3.year

            GROUP BY tb1.year
        ")
        ->pipe($this->dataStore("result3"));

        $this->src("database303")                 //MG
        ->query("
            SELECT tb1.year, tb1.SESM, tb2.SLASS, tb3.SLS
            FROM (SELECT em.year, SUM(em.noOfStudent) AS SESM
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>= '$start' AND em.year<='$end' AND s.schoolID='IUB_SHSESM'
            GROUP BY em.year) as tb1,
            (SELECT em.year, SUM(em.noOfStudent) AS SLASS
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>= '$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLASS'
            GROUP BY em.year) as tb2, (SELECT em.year, SUM(em.noOfStudent) AS SLS
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>= '$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLS'
            GROUP BY em.year) as tb3, tbl_exam_major eem
            where tb1.year = tb2.year and tb2.year = tb3.year
            GROUP BY tb1.year

        ")
        ->pipe($this->dataStore("result4"));

        $this->src("database303")                 //MG
        ->query("
            SELECT tb1.year, tb1.SECS, tb2.SESM, tb3.SLASS, tb4.SLS, tb5.SoB
            FROM (SELECT em.year, SUM(em.noOfStudent) AS SECS
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSECS'
            GROUP BY em.year) as tb1,
            (SELECT em.year, SUM(em.noOfStudent) AS SESM
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSESM'
            GROUP BY em.year) as tb2,
            (SELECT em.year, SUM(em.noOfStudent) AS SLASS
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLASS'
            GROUP BY em.year) as tb3,
            (SELECT em.year, SUM(em.noOfStudent) AS SLS
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLS'
            GROUP BY em.year) as tb4,
            (SELECT em.year, SUM(em.noOfStudent) AS SoB
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSOB'
            GROUP BY em.year) as tb5,
            tbl_exam_major eem
            WHERE tb1.year = tb2.year AND tb2.year = tb3.year AND tb3.year=tb4.year AND tb4.year=tb5.year
            GROUP BY tb1.year
        ")
        ->pipe($this->dataStore("result5"));


        $this->src("database303")                 //ME
        ->query("
            SELECT s.schoolName, SUM(em.noOfStudent) AS SECS
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND em.year ='$focus' AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot

            GROUP BY s.schoolID
        ")
        ->pipe($this->dataStore("result6"));

        $this->src("database303")
        ->query("
            SELECT s.schoolName, SUM(em.noOfStudent) AS SECS
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND em.year ='2014' AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot

            GROUP BY s.schoolID
        ")
        ->pipe($this->dataStore("result7"));

        $this->src("database303")
        ->query("
            SELECT s.schoolName, SUM(em.noOfStudent) AS SECS
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND em.year ='2015' AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot

            GROUP BY s.schoolID
        ")
        ->pipe($this->dataStore("result8"));

        $this->src("database303")
        ->query("
            SELECT s.schoolName, SUM(em.noOfStudent) AS SECS
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND em.year ='2016' AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot

            GROUP BY s.schoolID
        ")
        ->pipe($this->dataStore("result9"));

        $this->src("database303")
        ->query("
            SELECT s.schoolName, SUM(em.noOfStudent) AS SECS
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND em.year ='2017' AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot

            GROUP BY s.schoolID
        ")
        ->pipe($this->dataStore("result10"));

        $this->src("database303")
        ->query("
            SELECT s.schoolName, SUM(em.noOfStudent) AS SECS
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND em.year ='2018' AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot

            GROUP BY s.schoolID
        ")
        ->pipe($this->dataStore("result11"));

        $this->src("database303")
        ->query("
            SELECT m.majorName, sum(em.noOfStudent) as SN

            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year='2019' AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND s.schoolID='IUB_SHSOB'
            GROUP BY m.majorID

        ")
        ->pipe($this->dataStore("result12")); 

        $this->src("database303") //Me
        ->query("
            SELECT tb1.year,tb1.IUB_MACN , tb2.IUB_MFIN  , tb3.IUB_MMGT ,tb4.IUB_MHRM , tb5.IUB_MINB,
            tb6.IUB_MIVM , tb7.IUB_MMIS , tb8.IUB_MMKT , tb9.IUB_MECN
            FROM
            (SELECT em.year,sum(em.noOfStudent) AS IUB_MACN
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year='$focus' AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND s.schoolID='IUB_SHSOB' AND m.majorID='IUB_MACN'
            GROUP BY em.year) AS tb1,
            (SELECT em.year, sum(em.noOfStudent)  AS IUB_MFIN
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year='$focus' AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND s.schoolID='IUB_SHSOB' AND m.majorID='IUB_MFIN'
            GROUP BY em.year) AS tb2,
            (SELECT em.year, sum(em.noOfStudent)  AS IUB_MMGT
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year='$focus' AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND s.schoolID='IUB_SHSOB' AND m.majorID='IUB_MMGT'
            GROUP BY em.year) AS tb3,
            (SELECT em.year, sum(em.noOfStudent) AS IUB_MHRM
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year='$focus' AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND s.schoolID='IUB_SHSOB' AND m.majorID='IUB_MHRM'
            GROUP BY em.year) AS tb4,
            (SELECT em.year,sum(em.noOfStudent) AS IUB_MINB
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year='$focus' AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND s.schoolID='IUB_SHSOB' AND m.majorID='IUB_MINB'
            GROUP BY em.year) AS tb5,
            (SELECT em.year, sum(em.noOfStudent) AS IUB_MIVM
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year='$focus' AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND s.schoolID='IUB_SHSOB' AND m.majorID='IUB_MIVM'
            GROUP BY em.year) AS tb6,
            (SELECT em.year, sum(em.noOfStudent) AS IUB_MMIS
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year='$focus' AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND s.schoolID='IUB_SHSOB' AND m.majorID='IUB_MMIS'
            GROUP BY em.year) AS tb7,
            (SELECT em.year, sum(em.noOfStudent) AS IUB_MMKT
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year='$focus' AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND s.schoolID='IUB_SHSOB' AND m.majorID='IUB_MMKT'
            GROUP BY em.year) AS tb8,
            (SELECT em.year, sum(em.noOfStudent) AS IUB_MECN
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year='$focus' AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND s.schoolID='IUB_SHSOB' AND m.majorID='IUB_MECN'
            GROUP BY em.year) AS tb9,
            tbl_exam_major em
            WHERE tb1.year = tb2.year AND tb2.year = tb3.year AND tb3.year=tb4.year AND tb4.year=tb5.year AND tb5.year=tb6.year AND tb6.year=tb7.year AND tb7.year=tb8.year AND tb8.year=tb9.year
            GROUP BY tb1.year

        ")
        ->pipe($this->dataStore("result122"));


        $this->src("database303")                 //MG
        ->query("
            SELECT tb1.year as 'Year', tb1.ACN as 'Accounting', tb2.FIN as 'Finance', tb3.MGT as 'General Management', tb4.HRM as 'Human Resources Management', tb5.INB as 'International Business', tb6.IVM as 'Investment Management', tb7.MIS as 'Management Information Systems', tb8.MKT as 'Marketing', tb9.ECN as 'Economics'
            FROM (SELECT em.year, SUM(em.noOfStudent) AS ACN
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND em.majorID='IUB_MACN'
            GROUP BY em.year) as tb1,
            (SELECT em.year, SUM(em.noOfStudent) AS FIN
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSOB' AND em.majorID='IUB_MFIN'
            GROUP BY em.year) as tb2,
            (SELECT em.year, SUM(em.noOfStudent) AS MGT
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSOB' AND m.majorID='IUB_MMGT'
            GROUP BY em.year) as tb3,
            (SELECT em.year, SUM(em.noOfStudent) AS HRM
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSOB' AND m.majorID='IUB_MHRM'
            GROUP BY em.year) as tb4,
            (SELECT em.year, SUM(em.noOfStudent) AS INB
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSOB' AND m.majorID='IUB_MINB'
            GROUP BY em.year) as tb5,
            (SELECT em.year, SUM(em.noOfStudent) AS IVM
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSOB' AND m.majorID='IUB_MIVM'
            GROUP BY em.year) as tb6,
            (SELECT em.year, SUM(em.noOfStudent) AS MIS
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSOB' AND m.majorID='IUB_MMIS'
            GROUP BY em.year) as tb7,
            (SELECT em.year, SUM(em.noOfStudent) AS MKT
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSOB' AND m.majorID='IUB_MMKT'
            GROUP BY em.year) as tb8,
            (SELECT em.year, SUM(em.noOfStudent) AS ECN
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSOB' AND m.majorID='IUB_MECN'
            GROUP BY em.year) as tb9,
            tbl_exam_major em
            WHERE tb1.year = tb2.year AND tb2.year = tb3.year AND tb3.year=tb4.year AND tb4.year=tb5.year AND tb5.year=tb6.year AND tb6.year=tb7.year AND tb7.year=tb8.year AND tb8.year=tb9.year
            GROUP BY tb1.year
        ")
        ->pipe($this->dataStore("result13"));


        $this->src("database303")                 //ME
        ->query("
            SELECT em.semester, sum(em.noOfStudent) AS 'Total Student'
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND em.year='$focus' AND  s.schoolID='IUB_SHSOB'
            GROUP BY em.semester

        ")
        ->pipe($this->dataStore("result14"));






        $this->src("database303")                 //MG
        ->query("
            SELECT tb1.year, tb1.Spring, tb2.Summer, tb3.Autumn
            FROM (SELECT em.year, SUM(em.noOfStudent) AS Spring
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND em.year>='$start' AND em.year<='$end' AND em.semester='Spring' AND s.schoolID='IUB_SHSOB'
            GROUP BY em.year) as tb1,
            (SELECT em.year, SUM(em.noOfStudent) AS Summer
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND em.year>='$start' AND em.year<='$end' AND em.semester='Summer' AND s.schoolID='IUB_SHSOB'
            GROUP BY em.year) as tb2,
            (SELECT em.year, SUM(em.noOfStudent) AS Autumn
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND em.year>='$start' AND em.year<='$end' AND em.semester='Autumn' AND s.schoolID='IUB_SHSOB'
            GROUP BY em.year) as tb3, tbl_exam_major em
            where tb1.year = tb2.year and tb2.year = tb3.year
            GROUP BY tb1.year


        ")
        ->pipe($this->dataStore("result15"));

        $this->src("database303")                 //MG
        ->query("
            SELECT tb1.year as 'Year', tb1.IUB_MCEN as 'BSc - Computer Engineering', tb2.IUB_MCSC as 'BSc - Computer Science', tb3.IUB_MCSE as 'BSc - Computer Science and Engineering',
            tb4.IUB_MEEE as 'BSc - Electrical and Electronic Engineering', tb5.IUB_METE as 'BSc - Electronic and Telecommunication Engineering',
            tb6.IUB_MMAT as 'BSc - Mathematics (Hons)', tb7.IUB_MPHY as 'BSc - Physics (Hons)'


            FROM (SELECT em.year, SUM(em.noOfStudent) AS IUB_MCEN
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSECS' AND em.majorID='IUB_MCEN'
            GROUP BY em.year) as tb1,
            (SELECT em.year, SUM(em.noOfStudent) AS IUB_MCSC
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSECS' AND em.majorID='IUB_MCSC'
            GROUP BY em.year) as tb2,
            (SELECT em.year, SUM(em.noOfStudent) AS IUB_MCSE
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSECS' AND m.majorID='IUB_MCSE'
            GROUP BY em.year) as tb3,
            (SELECT em.year, SUM(em.noOfStudent) AS IUB_MEEE
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSECS' AND m.majorID='IUB_MEEE'
            GROUP BY em.year) as tb4,
            (SELECT em.year, SUM(em.noOfStudent) AS IUB_METE
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSECS' AND m.majorID='IUB_METE'
            GROUP BY em.year) as tb5,
            (SELECT em.year, SUM(em.noOfStudent) AS IUB_MMAT
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSECS' AND m.majorID='IUB_MMAT'
            GROUP BY em.year) as tb6,
            (SELECT em.year, SUM(em.noOfStudent) AS IUB_MPHY
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSECS' AND m.majorID='IUB_MPHY'
            GROUP BY em.year) as tb7,
            tbl_exam_major em
            WHERE tb1.year = tb2.year AND tb2.year = tb3.year AND tb3.year=tb4.year AND tb4.year=tb5.year AND tb5.year=tb6.year AND tb6.year=tb7.year
            GROUP BY tb1.year


        ")
        ->pipe($this->dataStore("result16"));

        $this->src("database303")                 //MG
        ->query("
            SELECT tb1.year, tb1.CSE, tb2.EEE, tb3.PS
            FROM (SELECT em.year, SUM(em.noOfStudent) AS CSE
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSECS' AND d.deptID='IUB_DCSE'
            GROUP BY em.year) as tb1,
            (SELECT em.year, SUM(em.noOfStudent) AS EEE
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSECS' AND d.deptID='IUB_DEEE'
            GROUP BY em.year) as tb2,
            (SELECT em.year, SUM(em.noOfStudent) AS PS
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSECS' AND d.deptID='IUB_DPHYSCI'
            GROUP BY em.year) as tb3, tbl_exam_major em
            where tb1.year = tb2.year and tb2.year = tb3.year
            GROUP BY tb1.year
        ")
        ->pipe($this->dataStore("result17"));

        $this->src("database303")                 //ME
        ->query("
            SELECT m.majorName, sum(em.noOfStudent) AS 'Total Student'
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND em.year='$focus' AND  s.schoolID='IUB_SHSECS'
            GROUP BY m.majorName
        ")
        ->pipe($this->dataStore("result18"));

        $this->src("database303")                 //ME
        ->query("
            SELECT d.deptName, sum(em.noOfStudent) AS 'Total Student'
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND em.year='$focus' AND  s.schoolID='IUB_SHSECS'
            GROUP BY d.deptName
        ")
        ->pipe($this->dataStore("result19"));

        $this->src("database303")                 //MG
        ->query("
            SELECT tb1.year,
            tb1.spring,
            tb2.summer,
            tb3.autumn
            FROM   (SELECT em.year,
                    Sum(em.noofstudent) AS Spring
            FROM   tbl_exam_major em,
                    tbl_exam e,
                    tbl_school s,
                    tbl_major m,
                    tlb_department d
            WHERE  d.schoolid = s.schoolid
                    AND m.deptid = d.deptid
                    AND em.majorid = m.majorid
                    AND e.year = em.year
                    AND e.semester = em.semester
                    AND e.slot = em.slot
                    AND em.year >='$start'
                    AND em.year<='$end'
                    AND em.semester = 'Spring'
                    AND s.schoolid = 'IUB_SHSECS'
            GROUP  BY em.year) AS tb1,
            (SELECT em.year,
                    Sum(em.noofstudent) AS Summer
            FROM   tbl_exam_major em,
                    tbl_exam e,
                    tbl_school s,
                    tbl_major m,
                    tlb_department d
            WHERE  d.schoolid = s.schoolid
                    AND m.deptid = d.deptid
                    AND em.majorid = m.majorid
                    AND e.year = em.year
                    AND e.semester = em.semester
                    AND e.slot = em.slot
                    AND em.year>='$start'
                    AND em.year<='$end'
                    AND em.semester = 'Summer'
                    AND s.schoolid = 'IUB_SHSECS'
            GROUP  BY em.year) AS tb2,
            (SELECT em.year,
                    Sum(em.noofstudent) AS Autumn
            FROM   tbl_exam_major em,
                    tbl_exam e,
                    tbl_school s,
                    tbl_major m,
                    tlb_department d
            WHERE  d.schoolid = s.schoolid
                    AND m.deptid = d.deptid
                    AND em.majorid = m.majorid
                    AND e.year = em.year
                    AND e.semester = em.semester
                    AND e.slot = em.slot
                    AND em.year >='$start'
                    AND em.year<='$end'
                    AND em.semester = 'Autumn'
                    AND s.schoolid = 'IUB_SHSECS'
            GROUP  BY em.year) AS tb3,
            tbl_exam_major em
            WHERE  tb1.year = tb2.year
            AND tb2.year = tb3.year
            GROUP  BY tb1.year
        ")
        ->pipe($this->dataStore("result20"));

        $this->src("database303")                 //ME
        ->query("
            SELECT em.semester, sum(em.noOfStudent) AS 'Total Student'
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND em.year='$focus' AND  s.schoolID='IUB_SHSECS'
            GROUP BY em.semester

        ")
        ->pipe($this->dataStore("result21"));

        $this->src("database303")                 //MG
        ->query("
            SELECT tb1.year, tb1.ELT, tb2.ENG, tb3.ANT, tb4.GSG, tb5.CMN, tb6.SOC, tb7.LLB
            FROM (SELECT em.year, SUM(em.noOfStudent) AS ELT
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLASS' AND d.deptID='IUB_DENG' AND em.majorID='IUB_MELT'
            GROUP BY em.year) as tb1,
            (SELECT em.year, SUM(em.noOfStudent) AS ENG
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLASS' AND d.deptID='IUB_DENG' AND em.majorID='IUB_MENG'
            GROUP BY em.year) as tb2,
            (SELECT em.year, SUM(em.noOfStudent) AS ANT
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLASS' AND d.deptID='IUB_DSOC' AND m.majorID='IUB_MANT'
            GROUP BY em.year) as tb3,
            (SELECT em.year, SUM(em.noOfStudent) AS GSG
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLASS' AND d.deptID='IUB_DGSG' AND m.majorID='IUB_MGSG'
            GROUP BY em.year) as tb4,
            (SELECT em.year, SUM(em.noOfStudent) AS CMN
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLASS' AND d.deptID='IUB_DMED' AND m.majorID='IUB_MCMN'
            GROUP BY em.year) as tb5,
            (SELECT em.year, SUM(em.noOfStudent) AS SOC
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLASS' AND d.deptID='IUB_DSOC' AND m.majorID='IUB_MSOC'
            GROUP BY em.year) as tb6,
            (SELECT em.year, SUM(em.noOfStudent) AS LLB
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLASS' AND d.deptID='IUB_DLAW' AND m.majorID='IUB_MLLB'
            GROUP BY em.year) as tb7,
            tbl_exam_major em
            WHERE tb1.year = tb2.year AND tb2.year = tb3.year AND tb3.year=tb4.year AND tb4.year=tb5.year AND tb5.year=tb6.year AND tb6.year=tb7.year
            GROUP BY tb1.year
        ")
        ->pipe($this->dataStore("result22"));

        $this->src("database303")                 //MG
        ->query("
            SELECT tb1.year, tb1.DENG as 'English', tb2.DGSG as 'Global Studies & Governance',
            tb3.DLAW as 'Law', tb4.DMED as 'Media and Communication', tb5.DSOC as 'Social Sciences and Humanities'
            FROM (SELECT em.year, SUM(em.noOfStudent) AS DENG
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLASS' AND d.deptID='IUB_DENG'
            GROUP BY em.year) as tb1,

            (SELECT em.year, SUM(em.noOfStudent) AS DGSG
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLASS' AND d.deptID='IUB_DGSG'
            GROUP BY em.year) as tb2,

            (SELECT em.year, SUM(em.noOfStudent) AS DLAW
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLASS' AND d.deptID='IUB_DLAW'
            GROUP BY em.year) as tb3,

            (SELECT em.year, SUM(em.noOfStudent) AS DMED
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLASS' AND d.deptID='IUB_DMED'
            GROUP BY em.year) as tb4,

            (SELECT em.year, SUM(em.noOfStudent) AS DSOC
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLASS' AND d.deptID='IUB_DSOC'
            GROUP BY em.year) as tb5,


            tbl_exam_major em
            where tb1.year = tb2.year and tb2.year = tb3.year and tb3.year = tb4.year and tb4.year = tb5.year
            GROUP BY tb1.year
        ")
        ->pipe($this->dataStore("result23"));

        $this->src("database303")                 //ME
        ->query("
            SELECT m.majorName, sum(em.noOfStudent) AS 'Total Student'
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND em.year='$focus' AND  s.schoolID='IUB_SHSLASS'
            GROUP BY m.majorName
        ")
        ->pipe($this->dataStore("result24"));

        $this->src("database303")                 //ME
        ->query("
            SELECT d.deptName, sum(em.noOfStudent) AS 'Total Student'
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND em.year='$focus' AND  s.schoolID='IUB_SHSLASS'
            GROUP BY d.deptName
        ")
        ->pipe($this->dataStore("result25"));

        $this->src("database303")                 //MG
        ->query("
            SELECT tb1.year,
            tb1.spring,
            tb2.summer,
            tb3.autumn
            FROM   (SELECT em.year,
                    Sum(em.noofstudent) AS Spring
            FROM   tbl_exam_major em,
                    tbl_exam e,
                    tbl_school s,
                    tbl_major m,
                    tlb_department d
            WHERE  d.schoolid = s.schoolid
                    AND m.deptid = d.deptid
                    AND em.majorid = m.majorid
                    AND e.year = em.year
                    AND e.semester = em.semester
                    AND e.slot = em.slot
                    AND em.year >='$start'
                    AND em.year<='$end'
                    AND em.semester = 'Spring'
                    AND s.schoolid = 'IUB_SHSLASS'
            GROUP  BY em.year) AS tb1,
            (SELECT em.year,
                    Sum(em.noofstudent) AS Summer
            FROM   tbl_exam_major em,
                    tbl_exam e,
                    tbl_school s,
                    tbl_major m,
                    tlb_department d
            WHERE  d.schoolid = s.schoolid
                    AND m.deptid = d.deptid
                    AND em.majorid = m.majorid
                    AND e.year = em.year
                    AND e.semester = em.semester
                    AND e.slot = em.slot
                    AND em.year >='$start'
                    AND em.year<='$end'
                    AND em.semester = 'Summer'
                    AND s.schoolid = 'IUB_SHSLASS'
            GROUP  BY em.year) AS tb2,
            (SELECT em.year,
                    Sum(em.noofstudent) AS Autumn
            FROM   tbl_exam_major em,
                    tbl_exam e,
                    tbl_school s,
                    tbl_major m,
                    tlb_department d
            WHERE  d.schoolid = s.schoolid
                    AND m.deptid = d.deptid
                    AND em.majorid = m.majorid
                    AND e.year = em.year
                    AND e.semester = em.semester
                    AND e.slot = em.slot
                    AND em.year >='$start'
                    AND em.year<='$end'
                    AND em.semester = 'Autumn'
                    AND s.schoolid = 'IUB_SHSLASS'
            GROUP  BY em.year) AS tb3,
            tbl_exam_major em
            WHERE  tb1.year = tb2.year
            AND tb2.year = tb3.year
            GROUP  BY tb1.year
        ")
        ->pipe($this->dataStore("result26"));

        $this->src("database303")                 //ME
        ->query("
            SELECT em.semester, sum(em.noOfStudent) AS 'Total Student'
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND em.year='$focus' AND  s.schoolID='IUB_SHSLASS'
            GROUP BY em.semester

        ")
        ->pipe($this->dataStore("result27"));

        $this->src("database303")                 //MG
        ->query("
            SELECT tb1.year, tb1.PHA, tb2.ENM, tb3.ENV, tb4.POP
            FROM (SELECT em.year, SUM(em.noOfStudent) AS PHA
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSESM' AND d.deptID='IUB_DPHAR' AND m.majorID='IUB_MPHA'
            GROUP BY em.year) as tb1,
            (SELECT em.year, SUM(em.noOfStudent) AS ENM
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSESM' AND d.deptID='IUB_DESC' AND m.majorID='IUB_MENM'
            GROUP BY em.year) as tb2,
            (SELECT em.year, SUM(em.noOfStudent) AS ENV
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSESM' AND d.deptID='IUB_DESC' AND m.majorID='IUB_MENV'
            GROUP BY em.year) as tb3,
            (SELECT em.year, SUM(em.noOfStudent) AS POP
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSESM' AND d.deptID='IUB_DPOP' AND m.majorID='IUB_MPOP'
            GROUP BY em.year) as tb4,
            tbl_exam_major em
            where tb1.year = tb2.year and tb2.year = tb3.year and tb3.year=tb4.year
            GROUP BY tb1.year
        ")
        ->pipe($this->dataStore("result28"));

        $this->src("database303")                 //MG
        ->query("
            SELECT tb1.year,
            tb1.spring,
            tb2.summer,
            tb3.autumn
            FROM   (SELECT em.year,
                    Sum(em.noofstudent) AS Spring
            FROM   tbl_exam_major em,
                    tbl_exam e,
                    tbl_school s,
                    tbl_major m,
                    tlb_department d
            WHERE  d.schoolid = s.schoolid
                    AND m.deptid = d.deptid
                    AND em.majorid = m.majorid
                    AND e.year = em.year
                    AND e.semester = em.semester
                    AND e.slot = em.slot
                    AND em.year >='$start'
                    AND em.year<='$end'
                    AND em.semester = 'Spring'
                    AND s.schoolid = 'IUB_SHSESM'
            GROUP  BY em.year) AS tb1,
            (SELECT em.year,
                    Sum(em.noofstudent) AS Summer
            FROM   tbl_exam_major em,
                    tbl_exam e,
                    tbl_school s,
                    tbl_major m,
                    tlb_department d
            WHERE  d.schoolid = s.schoolid
                    AND m.deptid = d.deptid
                    AND em.majorid = m.majorid
                    AND e.year = em.year
                    AND e.semester = em.semester
                    AND e.slot = em.slot
                    AND em.year >='$start'
                    AND em.year<='$end'
                    AND em.semester = 'Summer'
                    AND s.schoolid = 'IUB_SHSESM'
            GROUP  BY em.year) AS tb2,
            (SELECT em.year,
                    Sum(em.noofstudent) AS Autumn
            FROM   tbl_exam_major em,
                    tbl_exam e,
                    tbl_school s,
                    tbl_major m,
                    tlb_department d
            WHERE  d.schoolid = s.schoolid
                    AND m.deptid = d.deptid
                    AND em.majorid = m.majorid
                    AND e.year = em.year
                    AND e.semester = em.semester
                    AND e.slot = em.slot
                    AND em.year >='$start'
                    AND em.year<='$end'
                    AND em.semester = 'Autumn'
                    AND s.schoolid = 'IUB_SHSESM'
            GROUP  BY em.year) AS tb3,
            tbl_exam_major em
            WHERE  tb1.year = tb2.year
            AND tb2.year = tb3.year
            GROUP  BY tb1.year
        ")
        ->pipe($this->dataStore("result29"));

        $this->src("database303")                 //ME
        ->query("
            SELECT em.semester, sum(em.noOfStudent) AS 'Total Student'
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND em.year='$focus' AND  s.schoolID='IUB_SHSESM'
            GROUP BY em.semester

        ")
        ->pipe($this->dataStore("result30"));

        $this->src("database303")                 //ME
        ->query("
            SELECT m.majorName, sum(em.noOfStudent) AS 'Total Student'
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND em.year='$focus' AND  s.schoolID='IUB_SHSESM'
            GROUP BY m.majorName
        ")
        ->pipe($this->dataStore("result31"));

        $this->src("database303")                 //ME
        ->query("
            SELECT m.majorName, sum(em.noOfStudent) AS 'Total Student'
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND em.year='$focus' AND  s.schoolID='IUB_SHSLS'
            GROUP BY m.majorName
        ")
        ->pipe($this->dataStore("result32"));

        $this->src("database303")                 //MG
        ->query("
            SELECT tb1.year, tb1.BIO, tb2.BIT, tb3.MCB
            FROM (SELECT em.year, SUM(em.noOfStudent) AS BIO
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLS' AND d.deptID='IUB_DSLS' AND m.majorID='IUB_MBIO'
            GROUP BY em.year) as tb1,
            (SELECT em.year, SUM(em.noOfStudent) AS BIT
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLS' AND d.deptID='IUB_DSLS' AND m.majorID='IUB_MBIT'
            GROUP BY em.year) as tb2,
            (SELECT em.year, SUM(em.noOfStudent) AS MCB
            FROM tbl_exam_major em, tbl_school s, tbl_major m, tbl_exam e, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND
            em.year=e.year AND em.semester=e.semester AND e.slot=em.slot AND
            em.year>='$start' AND em.year<='$end' AND s.schoolID='IUB_SHSLS' AND d.deptID='IUB_DSLS' AND m.majorID='IUB_MMCB'
            GROUP BY em.year) as tb3,
            tbl_exam_major em
            where tb1.year = tb2.year and tb2.year = tb3.year
            GROUP BY tb1.year
        ")
        ->pipe($this->dataStore("result33"));

        $this->src("database303")                 //MG
        ->query("
            SELECT tb1.year,
            tb1.spring,
            tb2.summer,
            tb3.autumn
            FROM   (SELECT em.year,
                    Sum(em.noofstudent) AS Spring
            FROM   tbl_exam_major em,
                    tbl_exam e,
                    tbl_school s,
                    tbl_major m,
                    tlb_department d
            WHERE  d.schoolid = s.schoolid
                    AND m.deptid = d.deptid
                    AND em.majorid = m.majorid
                    AND e.year = em.year
                    AND e.semester = em.semester
                    AND e.slot = em.slot
                    AND em.year >='$start'
                    AND em.year<='$end'
                    AND em.semester = 'Spring'
                    AND s.schoolid = 'IUB_SHSLS'
            GROUP  BY em.year) AS tb1,
            (SELECT em.year,
                    Sum(em.noofstudent) AS Summer
            FROM   tbl_exam_major em,
                    tbl_exam e,
                    tbl_school s,
                    tbl_major m,
                    tlb_department d
            WHERE  d.schoolid = s.schoolid
                    AND m.deptid = d.deptid
                    AND em.majorid = m.majorid
                    AND e.year = em.year
                    AND e.semester = em.semester
                    AND e.slot = em.slot
                    AND em.year >='$start'
                    AND em.year<='$end'
                    AND em.semester = 'Summer'
                    AND s.schoolid = 'IUB_SHSLS'
            GROUP  BY em.year) AS tb2,
            (SELECT em.year,
                    Sum(em.noofstudent) AS Autumn
            FROM   tbl_exam_major em,
                    tbl_exam e,
                    tbl_school s,
                    tbl_major m,
                    tlb_department d
            WHERE  d.schoolid = s.schoolid
                    AND m.deptid = d.deptid
                    AND em.majorid = m.majorid
                    AND e.year = em.year
                    AND e.semester = em.semester
                    AND e.slot = em.slot
                    AND em.year >='$start'
                    AND em.year<='$end'
                    AND em.semester = 'Autumn'
                    AND s.schoolid = 'IUB_SHSLS'
            GROUP  BY em.year) AS tb3,
            tbl_exam_major em
            WHERE  tb1.year = tb2.year
            AND tb2.year = tb3.year
            GROUP  BY tb1.year
        ")
        ->pipe($this->dataStore("result34"));

        $this->src("database303")                 //ME
        ->query("
            SELECT em.semester, sum(em.noOfStudent) AS 'Total Student'
            FROM tbl_exam_major em, tbl_exam e, tbl_school s, tbl_major m, tlb_department d
            WHERE d.schoolID=s.schoolID AND m.deptID=d.deptID AND em.majorID=m.majorID AND e.year=em.year AND e.semester=em.semester AND e.slot=em.slot AND em.year='$focus' AND  s.schoolID='IUB_SHSLS'
            GROUP BY em.semester

        ")
        ->pipe($this->dataStore("result35"));













    }

}
