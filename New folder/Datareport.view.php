<html>
    <head>
        <title>Report of IUB</title>
        <body>
        <h1>Admission Trends of Independent University, Bangladesh</h1>

    <?php

    

    $focus =$_POST['focus'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    \koolreport\widgets\koolphp\Table::create(array(
        "dataStore"=>$this->dataStore('result'),
        "title"=>"Yearly students' interest semester wise results",
        "columns"=>array(
            "year"=>array(
                "label"=>"Year"
            ),
            "Spring"=>array(
                
                "label"=>"Spring"
                
            ),
            "Summer"=>array(
                
                "label"=>"Summer"
                
            ),
            "Autumn"=>array(
                
                "label"=>"Autumn"
                
            ),
            "Grand Total"=>array(
                "label"=>"Grand Total"
            )

        ),
        "cssClass"=>array(
            "table"=>"table table-bordered table-striped"
        )
    ));
    ?>

    <?php
    \koolreport\widgets\google\ColumnChart::create(array(
        "title"=>"Yearly students' interest semester wise",
        "dataSource"=>$this->dataStore('result'),
        "columns"=>array(
            "year"=>array(
                "Label"=>"Year"
            ),
            "Spring"=>array(
                
                "label"=>"Spring"
                
            ),
            "Summer"=>array(
                
                "label"=>"Summer"
                
            ),
            "Autumn"=>array(
                
                "label"=>"Autumn"
                
            )
            
                   
        ),
        "colorScheme"=>array("#4169E1","C9401B","6FAB13"),
        "options"=>array(
            "isStacked"=>true,
            

        )
    ));
    ?>    
    
    


    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>$focus."@IUB",
        "dataSource"=>$this->dataStore('result1'),
        "columns"=>array(
            "semester",
            "TotalStd"
                   
        ),
        "colorScheme"=>array("#4169E1","C9401B","6FAB13"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

<p style="page-break-before: always">

    <?php
    \koolreport\widgets\google\LineChart::create(array(
        "title"=>"Overall Interest @ IUB",
        "dataSource"=>$this->dataStore('result2'),
        "columns"=>array(
            "year",
            "No of Student"
                   
        ),

        "options"=>array( "is3D"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\LineChart::create(array(
        "title"=>"School wise Student Interest @ IUB",
        "dataSource"=>$this->dataStore('result3'),

        "columns"=>array(
            "year",
            
            "SOB"=>array(
                "label"=>"School of Business"
            ),
            "SECS"=>array(
                "label"=>"School of Engineering And Computer Science"),
            "OtherSchools"=>array(
                "label"=>"Other Schools"
            )
                   
        ),
        "colorScheme"=>array("#2B3860","#E8571C","#579FE7"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\LineChart::create(array(
        "title"=>"Other Schools",
        "dataSource"=>$this->dataStore('result4'),

        "columns"=>array(
            "year",
            
            "SESM"=>array(
                "label"=>"SESM+PHARMA"
            ),
            "SLASS"=>array(
                "label"=>"SLASS"),
            "SLS"=>array(
                "label"=>"SLS"
            )
                   
        ),
        "colorScheme"=>array("#1E1A3E","#868781","#85943C"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

<p style="page-break-before: always">

    

    <?php
    \koolreport\widgets\google\AreaChart::create(array(
        "title"=>"School Wise Interest @ IUB",
        "dataSource"=>$this->dataStore('result5'),

        "columns"=>array(
            "year",
            
            "SESM"=>array(
                "label"=>"SESM+PHARMA"
            ),
            "SLASS"=>array(
                "label"=>"SLASS"),
            "SLS"=>array(
                "label"=>"SLS"
            ),
            "SECS"=>array(
                "label"=>"SECS"
            ),
            "SoB"=>array(
                "label"=>"SoB"
            )
            ),
            "colorScheme"=>array("#9B59B6","#8BAD87","#6E9B26","#D35400","#154360")
    ));
    ?>

    <?php
    \koolreport\widgets\google\ColumnChart::create(array(
        "title"=>"School Wise Interest @ IUB",
        "dataSource"=>$this->dataStore('result5'),

        "columns"=>array(
            "year",
            
            "SESM"=>array(
                "label"=>"SESM+PHARMA"
            ),
            "SLASS"=>array(
                "label"=>"SLASS"),
            "SLS"=>array(
                "label"=>"SLS"
            ),
            "SECS"=>array(
                "label"=>"SECS"
            ),
            "SoB"=>array(
                "label"=>"SoB"
            )
                   
        ), 
        "colorScheme"=>array("#9B59B6","#8BAD87","#6E9B26","#D35400","#154360")
    ));
    ?>

<p style="page-break-before: always">

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"2019 School wise Distribution",
        "dataSource"=>$this->dataStore('result6'),
        "columns"=>array(
            "schoolName",
            "SECS"     
        ),
        "colorScheme"=>array("#D35400","#9B59B6","#8BAD87","#6E9B26","#154360"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"2014 School wise Distribution",
        "dataSource"=>$this->dataStore('result7'),
        "columns"=>array(
            "schoolName",
            "SECS"     
        ),
        "colorScheme"=>array("#D35400","#9B59B6","#8BAD87","#6E9B26","#154360"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"2015 School wise Distribution",
        "dataSource"=>$this->dataStore('result8'),
        "columns"=>array(
            "schoolName",
            "SECS"     
        ),
        "colorScheme"=>array("#D35400","#9B59B6","#8BAD87","#6E9B26","#154360"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

<p style="page-break-before: always">

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"2016 School wise Distribution",
        "dataSource"=>$this->dataStore('result9'),
        "columns"=>array(
            "schoolName",
            "SECS"     
        ),
        "colorScheme"=>array("#D35400","#9B59B6","#8BAD87","#6E9B26","#154360"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"2017 School wise Distribution",
        "dataSource"=>$this->dataStore('result10'),
        "columns"=>array(
            "schoolName",
            "SECS"     
        ),
        "colorScheme"=>array("#D35400","#9B59B6","#8BAD87","#6E9B26","#154360"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"2018 School wise Distribution",
        "dataSource"=>$this->dataStore('result11'),
        "columns"=>array(
            "schoolName",
            "SECS"     
        ),
        "colorScheme"=>array("#D35400","#9B59B6","#8BAD87","#6E9B26","#154360"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

<p style="page-break-before: always">

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"2019 @ SoB",
        "dataSource"=>$this->dataStore('result12'),
        "columns"=>array(
            "majorName",
            "SN"=>array("label"=>"Major")    
        ),
        "colorScheme"=>array("#2C76A4","#38721C","#BE5038","#7646A0","#3D9FB5","#D35400","#71A92D","#234894","#791A09"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

<?php
    \koolreport\widgets\google\ColumnChart::create(array(
        "title"=>"2019 @ SoB",
        "dataSource"=>$this->dataStore('result122'),
        "columns"=>array(
            'year'=>array('label'=>'Year'),
            'IUB_MACN'=>array('label'=>'Acounting'),
            'IUB_MFIN'=>array('label'=>'Finance'), 
            'IUB_MMGT'=>array('label'=>'General Management'),
            'IUB_MHRM'=>array('label'=>'Human Resources Management'),
            'IUB_MINB'=>array('label'=>'International Business'), 
            'IUB_MIVM'=>array('label'=>'Investment Management'), 
            'IUB_MMIS'=>array('label'=>'Management Information Systems'), 
            'IUB_MMKT'=>array('label'=>'Marketing'),
            'IUB_MECN'=>array('label'=>'Economics')    
        ),
        "colorScheme"=>array("#2C76A4","#BE5038","#71A92D","#7646A0","#3D9FB5","#D35400","#234894","#791A09","#38721C"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\AreaChart::create(array(
        "title"=>"Major wise Students' interest @ SoB",
        "dataSource"=>$this->dataStore('result13'),
        "columns"=>array(
            "Year",
            "Accounting",
            "Finance",
            "General Management",
            "Human Resources Management",
            "International Business",
            "Investment Management",
            "Management Information Systems",
            "Marketing",
            "Economics"


        ),
        "colorScheme"=>array("#2C76A4","#BE5038","#71A92D","#7646A0","#3D9FB5","#D35400","#234894","#791A09","#38721C"),
       
    ));
    ?>
    
<p style="page-break-before: always">

    <?php
    \koolreport\widgets\google\LineChart::create(array(
        "title"=>"Major wise Students' interest @ SoB",
        "dataSource"=>$this->dataStore('result13'),
        "columns"=>array(
            "Year",
            "Accounting",
            "Finance",
            "General Management",
            "Human Resources Management",
            "International Business",
            "Investment Management",
            "Management Information Systems",
            "Marketing",
            "Economics"


        ),
        "colorScheme"=>array("#2C76A4","#BE5038","#71A92D","#7646A0","#3D9FB5","#D35400","#234894","#791A09","#38721C")
       
    ));
    ?>
    

    <?php
    \koolreport\widgets\google\ColumnChart::create(array(
        "title"=>"Yearly semester wise SoB",
        "dataSource"=>$this->dataStore('result15'),
        "columns"=>array(
            "year",
            "Spring",
            "Summer",
            "Autumn"     
        ),
        "colorScheme"=>array("#4169E1","C9401B","6FAB13"),
        "options"=>array( "isStacked"=>true)
    ));
    ?>
    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"2019 @ SoB",
        "dataSource"=>$this->dataStore('result14'),
        "columns"=>array(
            "semester",
            "Total Student"    
        ),
        "colorScheme"=>array("6FAB13","#4169E1","C9401B"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

<p style="page-break-before: always">

    <?php
    \koolreport\widgets\google\LineChart::create(array(
        "title"=>"Major wise Students' interest @ SECS",
        "dataSource"=>$this->dataStore('result16'),
        "columns"=>array(
            "Year",
            "BSc - Computer Engineering",
           
            "BSc - Computer Science",
            "BSc - Computer Science and Engineering",
            "BSc - Electrical and Electronic Engineering",
            "BSc - Electronic and Telecommunication Engineering",
            "BSc - Mathematics (Hons)",
            "BSc - Physics (Hons)"


        ),
        "colorScheme"=>array("#CA6F1E","#EB984E","#A04000","#DC7633","#EB984E", "#E59866","#EDBB99")
       
    ));
    ?>

    <?php
    \koolreport\widgets\google\AreaChart::create(array(
        "title"=>"Major wise Students' interest @ SECS",
        "dataSource"=>$this->dataStore('result16'),
        "columns"=>array(
            "Year",
            "BSc - Computer Engineering",
           
            "BSc - Computer Science",
            "BSc - Computer Science and Engineering",
            "BSc - Electrical and Electronic Engineering",
            "BSc - Electronic and Telecommunication Engineering",
            "BSc - Mathematics (Hons)",
            "BSc - Physics (Hons)"


        ),
        "colorScheme"=>array("#CA6F1E","#EB984E","#A04000","#DC7633","#EB984E", "#E59866","#EDBB99")
       
    ));
    ?>

    <?php
    \koolreport\widgets\google\LineChart::create(array(
        "title"=>"SECS Departments",
        "dataSource"=>$this->dataStore('result17'),
        "columns"=>array(
            "year",
            "CSE",
           
            "EEE",
            "PS"

        ),

        "colorScheme"=>array("#A04000","#DC7633","#EDBB99")
       
    ));
    ?>

<p style="page-break-before: always">

    <?php
    \koolreport\widgets\google\ColumnChart::create(array(
        "title"=>"SECS Departments",
        "dataSource"=>$this->dataStore('result17'),
        "columns"=>array(
            "year",
            "CSE",
            "EEE",
            "PS"

        ),
        "colorScheme"=>array("#A04000","#DC7633","#EDBB99"),
        "options"=>array("isStacked"=>true)
       
    ));
    ?>

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"2019 @ SECS Majors",
        "dataSource"=>$this->dataStore('result18'),
        "columns"=>array(
            "majorName",
            "Total Student"=>array("label"=>"Major")    
        ),

        "colorScheme"=>array("#CA6F1E","#EB984E","#A04000","#DC7633","#EB984E", "#E59866","#EDBB99"),
        

        "options"=>array( "is3D"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"SECS departments 2019",
        "dataSource"=>$this->dataStore('result19'),
        "columns"=>array(
            "deptName",
            "Total Student"=>array("label"=>"Departments")    
        ),

        "colorScheme"=>array("#A04000","#DC7633","#EDBB99"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

<p style="page-break-before: always">

    <?php
    \koolreport\widgets\google\ColumnChart::create(array(
        "title"=>"Yearly semester wise SECS",
        "dataSource"=>$this->dataStore('result20'),
        "columns"=>array(
            "year",
            "spring"=>array("label"=>'Spring'),
            "summer"=>array("label"=>'Summer'),
            "autumn"=>array("label"=>'Autumn')     
        ),
        "colorScheme"=>array("#4169E1","C9401B","6FAB13"),
        "options"=>array( "isStacked"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"2019 @ SECS",
        "dataSource"=>$this->dataStore('result21'),
        "columns"=>array(
            "semester",
            "Total Student"    
        ),
        "colorScheme"=>array("6FAB13","#4169E1","C9401B"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\LineChart::create(array(
        "title"=>"Major wise Students' interest @ SLASS",
        "dataSource"=>$this->dataStore('result22'),
        "columns"=>array(
            "year",
            "ELT"=>array("label"=>"English Language Teaching"), 
            "ENG"=>array("label"=>"English Literature"),
            "ANT"=>array("label"=>"Anthropology"), 
            "GSG"=>array("label"=>"Global Studies and Governance"), 
            "CMN"=>array("label"=>"Media and Communication"), 
            "SOC"=>array("label"=>"Sociology"),
            "LLB"=>array("label"=>"Laws")

        ),
        "colorScheme"=>array("#212F3D", "#ABB2B9", "#808B96", "#2C3E50","#D5D8DC","#808B96","#566573"),
       
    ));
    ?>

<p style="page-break-before: always">

    <?php
    \koolreport\widgets\google\AreaChart::create(array(
        "title"=>"Major wise Students' interest @ SLASS",
        "dataSource"=>$this->dataStore('result22'),
        "columns"=>array(
            "year",
            "ELT"=>array("label"=>"English Language Teaching"), 
            "ENG"=>array("label"=>"English Literature"),
            "ANT"=>array("label"=>"Anthropology"), 
            "GSG"=>array("label"=>"Global Studies and Governance"), 
            "CMN"=>array("label"=>"Media and Communication"), 
            "SOC"=>array("label"=>"Sociology"),
            "LLB"=>array("label"=>"Laws")

        ),
        "colorScheme"=>array("#212F3D", "#ABB2B9", "#808B96", "#2C3E50","#D5D8DC","#808B96","#566573"),
       
    ));
    ?>

    <?php
    \koolreport\widgets\google\LineChart::create(array(
        "title"=>"SLASS Departments",
        "dataSource"=>$this->dataStore('result23'),
        "columns"=>array(
            "year",
            'English',
            'Global Studies & Governance', 
            'Law',
            'Media and Communication',
            'Social Sciences and Humanities'

        ),
        "colorScheme"=>array("#717D7E", "#515A5A", "#D5DBDB","#212F3C", "#99A3A4")
       
    ));
    ?>

    <?php
    \koolreport\widgets\google\ColumnChart::create(array(
        "title"=>"SLASS Departments",
        "dataSource"=>$this->dataStore('result23'),
        "columns"=>array(
            "year",
            'English',
            'Global Studies & Governance', 
            'Law',
            'Media and Communication',
            'Social Sciences and Humanities'

        ),
        "colorScheme"=>array("#99A3A4","#212F3C", "#D5DBDB","#515A5A","#717D7E"),
        "options"=>array("isStacked"=>true)
       
    ));
    ?>

<p style="page-break-before: always">

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"2019 @ SLASS Majors",
        "dataSource"=>$this->dataStore('result24'),
        "columns"=>array(
            "majorName",
            "Total Student"=>array("label"=>"Major")    
        ),
        "colorScheme"=>array("#212F3D", "#ABB2B9", "#808B96", "#2C3E50","#D5D8DC","#808B96","#566573"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"SLASS departments 2019",
        "dataSource"=>$this->dataStore('result25'),
        "columns"=>array(
            "deptName",
            "Total Student"=>array("label"=>"Departments")    
        ),
        "colorScheme"=>array("#717D7E","#D5DBDB","#212F3C","#99A3A4","#515A5A"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\ColumnChart::create(array(
        "title"=>"Yearly semester wise SLASS",
        "dataSource"=>$this->dataStore('result26'),
        "columns"=>array(
            "year",
            "spring"=>array("label"=>'Spring'),
            "summer"=>array("label"=>'Summer'),
            "autumn"=>array("label"=>'Autumn')     
        ),
        "colorScheme"=>array("#4169E1","C9401B","6FAB13"),
        "options"=>array( "isStacked"=>true)
    ));
    ?>

<p style="page-break-before: always">

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"2019 @ SLASS",
        "dataSource"=>$this->dataStore('result27'),
        "columns"=>array(
            "semester",
            "Total Student"    
        ),
        "colorScheme"=>array("6FAB13","#4169E1","C9401B"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\LineChart::create(array(
        "title"=>"Major wise Students' interest @ SESM+Pharmacy",
        "dataSource"=>$this->dataStore('result28'),
        "columns"=>array(
            'year'=>array("label"=>"Year"), 
            'PHA'=>array("label"=>"Pharmacy"), 
            'ENM'=>array("label"=>"Environmental Management"), 
            'ENV'=>array("label"=>"Environmental Science"), 
            'POP'=>array("label"=>"Population Environment")   
        ),
        "colorScheme"=>array("#4A235A","#6C3483","#9B59B6","#C39BD3"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\AreaChart::create(array(
        "title"=>"Major wise Students' interest @ SESM+Pharmacy",
        "dataSource"=>$this->dataStore('result28'),
        "columns"=>array(
            'year'=>array("label"=>"Year"), 
            'PHA'=>array("label"=>"Pharmacy"), 
            'ENM'=>array("label"=>"Environmental Management"), 
            'ENV'=>array("label"=>"Environmental Science"), 
            'POP'=>array("label"=>"Population Environment")   
        ),
        "colorScheme"=>array("#4A235A","#6C3483","#9B59B6","#C39BD3"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

<p style="page-break-before: always">

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"2019 @ SESM+Pharmacy Majors",
        "dataSource"=>$this->dataStore('result31'),
        "columns"=>array(
            "majorName",
            "Total Student"=>array("label"=>"Major")    
        ),
        "colorScheme"=>array("#4A235A","#6C3483","#9B59B6","#C39BD3"),
        "options"=>array( "is3D"=>true)
    ));
    ?>


    <?php
    \koolreport\widgets\google\ColumnChart::create(array(
        "title"=>"Yearly semester wise SESM+Pharmacy",
        "dataSource"=>$this->dataStore('result29'),
        "columns"=>array(
            "year",
            "spring"=>array("label"=>'Spring'),
            "summer"=>array("label"=>'Summer'),
            "autumn"=>array("label"=>'Autumn')     
        ),
        "colorScheme"=>array("#4169E1","C9401B","6FAB13"),
        "options"=>array( "isStacked"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"2019 @ SESM+Pharmacy",
        "dataSource"=>$this->dataStore('result30'),
        "columns"=>array(
            "semester",
            "Total Student"    
        ),
        "colorScheme"=>array("6FAB13","#4169E1","C9401B"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

    
<p style="page-break-before: always">

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"2019 @ SLS Majors",
        "dataSource"=>$this->dataStore('result32'),
        "columns"=>array(
            "majorName",
            "Total Student"=>array("label"=>"Major")    
        ),
        "colorScheme"=>array("#05530A", "#4BB351", "#1A8B21"),
        "options"=>array( "is3D"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\LineChart::create(array(
        "title"=>"Major wise Students' interest @ SLS",
        "dataSource"=>$this->dataStore('result33'),
        "columns"=>array(
            'year'=>array("label"=>"Year"), 
            'BIO'=>array("label"=>"Biochemistry"), 
            'BIT'=>array("label"=>" Biochemistry and Biotechnology"), 
            'MCB'=>array("label"=>"Microbiology")
             
        ),
        "colorScheme"=>array("#05530A", "#4BB351", "#1A8B21")
        
    ));
    ?>

    <?php
    \koolreport\widgets\google\AreaChart::create(array(
        "title"=>"Major wise Students' interest @ SLS",
        "dataSource"=>$this->dataStore('result33'),
        "columns"=>array(
            'year'=>array("label"=>"Year"), 
            'BIO'=>array("label"=>"Biochemistry"), 
            'BIT'=>array("label"=>" Biochemistry and Biotechnology"), 
            'MCB'=>array("label"=>"Microbiology")
             
        ),
        "colorScheme"=>array("#05530A", "#4BB351", "#1A8B21")
        
    ));
    ?>

<p style="page-break-before: always">

    <?php
    \koolreport\widgets\google\ColumnChart::create(array(
        "title"=>"Yearly semester wise SLS",
        "dataSource"=>$this->dataStore('result34'),
        "columns"=>array(
            "year",
            "spring"=>array("label"=>'Spring'),
            "summer"=>array("label"=>'Summer'),
            "autumn"=>array("label"=>'Autumn')     
        ),
        "colorScheme"=>array("#4169E1","C9401B","6FAB13"),
        "options"=>array( "isStacked"=>true)
    ));
    ?>

    <?php
    \koolreport\widgets\google\PieChart::create(array(
        "title"=>"2019 @ SLS",
        "dataSource"=>$this->dataStore('result35'),
        "columns"=>array(
            "semester",
            "Total Student"    
        ),
        "colorScheme"=>array("6FAB13","#4169E1","C9401B"),
        "options"=>array( "is3D"=>true)
    ));
    ?>







        <body>
</html>
