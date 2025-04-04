<script>
        $(function() {
            'use strict'

            var ctx1 = document.getElementById('chartBar1').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: [
                        <?php
                        $the_year = $_SESSION["current_year"];

                        $find_distinct_months_query = $connect->prepare("SELECT DISTINCT MONTH(date) AS distinct_month FROM transactions WHERE YEAR(date) = ?");
                        $find_distinct_months_query->execute([$the_year]);
                        while($row=$find_distinct_months_query->fetch(PDO::FETCH_ASSOC)){
                            $distinct_month = $row["distinct_month"];
                            
                            $monthName = date('F', mktime(0, 0, 0, $distinct_month, 1));
                            
                             echo "'".$monthName."',";
                        }
                        ?>
                       
                    ],
                    datasets: [{
                            data: [
                                <?php
                                $the_year = $_SESSION["current_year"];
                                $credit = "credit";
                                $curr_usd = "usd";
                                $curr_zwl = "zwl";
                                

                                $find_distinct_months_query = $connect->prepare("SELECT DISTINCT MONTH(date) AS distinct_month FROM transactions WHERE YEAR(date) = ?");
                                $find_distinct_months_query->execute([$the_year]);
                                while($row=$find_distinct_months_query->fetch(PDO::FETCH_ASSOC)){
                                    $distinct_month = $row["distinct_month"];
                            
                                    $find_usd_income_query = $connect->prepare("SELECT SUM(amount) AS total_usd_income FROM transactions WHERE MONTH(date)=? AND YEAR(date)=? AND type=? AND currency=?");
                                    $find_usd_income_query->execute([$distinct_month,$the_year,$credit,$curr_usd]);
                                    while($row=$find_usd_income_query->fetch(PDO::FETCH_ASSOC)){
                                        $total_usd_income = $row["total_usd_income"];
                                    }
                                    
                                    
                                    $find_zwl_income_query = $connect->prepare("SELECT SUM(amount) AS total_zwl_income FROM transactions WHERE MONTH(date)=? AND YEAR(date)=? AND type=? AND currency=?");
                                    $find_zwl_income_query->execute([$distinct_month,$the_year,$credit,$curr_zwl]);
                                    while($row=$find_zwl_income_query->fetch(PDO::FETCH_ASSOC)){
                                        $total_zwl_income = $row["total_zwl_income"];
                                    }
                                    
                                    $zwl_to_usd_income = $total_zwl_income / $zwl;
                                    
                                    $total_income_amt = $total_usd_income + $zwl_to_usd_income;
                                    
                                    echo round($total_income_amt).",";
                                    
                                }
                        ?>
                                ],
                            backgroundColor: '#5368FA',
                            label: 'Monthly Expense'
                        },
                        {
                            data: [
                                <?php
                                $the_year = $_SESSION["current_year"];
                                $credit = "debit";
                                $curr_usd = "usd";
                                $curr_zwl = "zwl";
                                

                                $find_distinct_months_query = $connect->prepare("SELECT DISTINCT MONTH(date) AS distinct_month FROM transactions WHERE YEAR(date) = ?");
                                $find_distinct_months_query->execute([$the_year]);
                                while($row=$find_distinct_months_query->fetch(PDO::FETCH_ASSOC)){
                                    $distinct_month = $row["distinct_month"];
                            
                                    $find_usd_expenses_query = $connect->prepare("SELECT SUM(amount) AS total_usd_expenses FROM transactions WHERE MONTH(date)=? AND YEAR(date)=? AND type=? AND currency=?");
                                    $find_usd_expenses_query->execute([$distinct_month,$the_year,$credit,$curr_usd]);
                                    while($row=$find_usd_expenses_query->fetch(PDO::FETCH_ASSOC)){
                                        $total_usd_expenses = $row["total_usd_expenses"];
                                    }
                                    
                                    
                                    $find_zwl_expenses_query = $connect->prepare("SELECT SUM(amount) AS total_zwl_expenses FROM transactions WHERE MONTH(date)=? AND YEAR(date)=? AND type=? AND currency=?");
                                    $find_zwl_expenses_query->execute([$distinct_month,$the_year,$credit,$curr_zwl]);
                                    while($row=$find_zwl_expenses_query->fetch(PDO::FETCH_ASSOC)){
                                        $total_zwl_expenses = $row["total_zwl_expenses"];
                                    }
                                    
                                    $zwl_to_usd_expenses = $total_zwl_expenses / $zwl;
                                    
                                    $total_expenses_amt = $total_usd_expenses + $zwl_to_usd_expenses;
                                    
                                    echo round($total_expenses_amt).",";
                                    
                                }
                        ?>
                            ], // Second set of data
                            backgroundColor: '#7ebcff', // Adjust color as needed
                            label: 'Monthly Total Plates'
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: true,
                        labels: {
                            display: true
                        }
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            barPercentage: 0.5
                        }],
                        yAxes: [{
                            gridLines: {
                                color: '#ebeef3'
                            },
                            ticks: {
                                fontColor: '#8392a5',
                                fontSize: 10,
                                min: 0,
                                
                            }
                        }]
                    }
                }
            });


            /** PIE CHART **/
            <?php
            if($role == "admin"){
                ?>
                        var datapie = {

                labels: ['Male Members', 'Female Members'],
                datasets: [{
                    data: [<?php echo $count_all_male_students?>,<?php echo $count_all_female_students
;?>],
                    backgroundColor: ['#7ebcff', '#5368FA', '#7ee5e5', '#fdbd88']
                }]
            };
            <?php
            }elseif($role == "hod" || $role == "emp"){
               ?>
                        var datapie = {

                labels: ['Male Term Performance', 'Female Term Performance'],
                datasets: [{
                    data: [<?php echo round($the_avarage_performance_male,2)?>,<?php echo round($the_avarage_performance_female,2)
;?>],
                    backgroundColor: ['#7ebcff', '#5368FA', '#7ee5e5', '#fdbd88']
                }]
            };
            <?php
            }
            ?>
            
            
            var datapie_employees = {

                labels: ['Male Employees', 'Female Employees'],
                datasets: [{
                    data: [<?php echo $count_all_male_employees;?>, <?php echo $count_all_female_employees;?>],
                    backgroundColor: ['#7ebcff', '#5368FA']
                }]
            };
            
            
            

            var datapie_students = {
                labels: ['Male Students', 'Female Students'],
                datasets: [{
                    data: [<?php echo $count_all_male_students;?>,<?php echo $count_all_female_students;?>],
                    backgroundColor: ['#7ebcff', '#5368FA']
                }]
            };

            var datapie_classes = {
                labels: ['Classes'],
                datasets: [{
                    data: [<?php echo $count_all_classes;?>],
                    backgroundColor: ['#7ebcff', '#5368FA']
                }]
            };


            var datapie_departments = {

                labels: ['Main Departments', 'Sub Departments'],
                datasets: [{
                    data: [67.45],
                    backgroundColor: ['#7ebcff', '#5368FA']
                }]
            };




            var optionpie = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false,
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            };

            // For a pie chart
            var ctx2 = document.getElementById('chartDonut');
            var myDonutChart = new Chart(ctx2, {
                type: 'doughnut',
                data: datapie,
                options: optionpie
            });

            // For a pie chart
            var ctx3 = document.getElementById('chartDonut_active_emps');
            var myDonutChart = new Chart(ctx3, {
                type: 'doughnut',
                data: datapie_employees,
                options: optionpie
            });
            
            
          

            // For a pie chart
            var ctx3 = document.getElementById('chartDonut_active_students');
            var myDonutChart = new Chart(ctx3, {
                type: 'doughnut',
                data: datapie_students,
                options: optionpie
            });

            // For a pie chart
            var ctx3 = document.getElementById('chartDonut_active_classes');
            var myDonutChart = new Chart(ctx3, {
                type: 'doughnut',
                data: datapie_classes,
                options: optionpie
            });



            var ctx4 = document.getElementById('chartDonut_departments');
            var myDonutChart = new Chart(ctx4, {
                type: 'doughnut',
                data: datapie_departments,
                options: optionpie
            });






            $.plot('#flotChart1', [{
                data: df1,
                color: '#c0ccda',
                lines: {
                    fill: true,
                    fillColor: '#f5f6fa'
                }
            }, {
                data: df3,
                color: '#0168fa',
                lines: {
                    fill: true,
                    fillColor: '#d1e6fa'
                }
            }], {
                series: {
                    shadowSize: 0,
                    lines: {
                        show: true,
                        lineWidth: 1.5
                    }
                },
                grid: {
                    borderWidth: 0,
                    labelMargin: 0
                },
                yaxis: {
                    show: false,
                    max: 65
                },
                xaxis: {
                    show: false,
                    min: 40,
                    max: 100
                }
            });


            $.plot('#flotChart2', [{
                data: df2,
                color: '#66a4fb',
                lines: {
                    show: true,
                    lineWidth: 1.5,
                    fill: .03
                }
            }, {
                data: df1,
                color: '#00cccc',
                lines: {
                    show: true,
                    lineWidth: 1.5,
                    fill: true,
                    fillColor: '#fff'
                }
            }, {
                data: df3,
                color: '#e3e7ed',
                bars: {
                    show: true,
                    lineWidth: 0,
                    barWidth: .5,
                    fill: 1
                }
            }], {
                series: {
                    shadowSize: 0
                },
                grid: {
                    aboveData: true,
                    color: '#e5e9f2',
                    borderWidth: {
                        top: 0,
                        right: 1,
                        bottom: 1,
                        left: 1
                    },
                    labelMargin: 0
                },
                yaxis: {
                    show: false,
                    min: 0,
                    max: 100
                },
                xaxis: {
                    show: true,
                    min: 40,
                    max: 80,
                    ticks: 6,
                    tickColor: 'rgba(0,0,0,0.04)'
                }
            });

            var df3data1 = [
                [0, 12],
                [1, 10],
                [2, 7],
                [3, 11],
                [4, 15],
                [5, 20],
                [6, 22],
                [7, 19],
                [8, 18],
                [9, 20],
                [10, 17],
                [11, 19],
                [12, 18],
                [13, 14],
                [14, 9]
            ];
            var df3data2 = [
                [0, 0],
                [1, 0],
                [2, 0],
                [3, 2],
                [4, 5],
                [5, 2],
                [6, 12],
                [7, 15],
                [8, 10],
                [9, 8],
                [10, 10],
                [11, 7],
                [12, 2],
                [13, 4],
                [14, 0]
            ];
            var df3data3 = [
                [0, 2],
                [1, 1],
                [2, 2],
                [3, 4],
                [4, 2],
                [5, 1],
                [6, 0],
                [7, 0],
                [8, 5],
                [9, 2],
                [10, 8],
                [11, 6],
                [12, 9],
                [13, 2],
                [14, 0]
            ];
            var df3data4 = [
                [0, 0],
                [1, 5],
                [2, 2],
                [3, 0],
                [4, 2],
                [5, 7],
                [6, 10],
                [7, 12],
                [8, 8],
                [9, 6],
                [10, 4],
                [11, 2],
                [12, 0],
                [13, 0],
                [14, 0]
            ];

            var flotChartOption1 = {
                series: {
                    shadowSize: 0,
                    bars: {
                        show: true,
                        lineWidth: 0,
                        barWidth: .5,
                        fill: 1
                    }
                },
                grid: {
                    aboveData: true,
                    color: '#e5e9f2',
                    borderWidth: 0,
                    labelMargin: 0
                },
                yaxis: {
                    show: false,
                    min: 0,
                    max: 25
                },
                xaxis: {
                    show: true,
                    ticks: [
                        [0, "34"],
                        [14.0, "45"]
                    ] // Define custom ticks with labels
                }
            };

            $.plot('#flotChart3', [{
                data: df3data1,
                color: '#e5e9f2'
            }, {
                data: df3data2,
                color: '#66a4fb'
            }], flotChartOption1);


            $.plot('#flotChart4', [{
                data: df3data1,
                color: '#e5e9f2'
            }, {
                data: df3data3,
                color: '#7ee5e5'
            }], flotChartOption1);

            $.plot('#flotChart6', [{
                data: df3data1,
                color: '#e5e9f2'
            }, {
                data: df3data3,
                color: '#7ee5e5'
            }], flotChartOption1);

            $.plot('#flotChart5', [{
                data: df3data1,
                color: '#e5e9f2'
            }, {
                data: df3data4,
                color: '#f77eb9'
            }], flotChartOption1);

        })
    </script>