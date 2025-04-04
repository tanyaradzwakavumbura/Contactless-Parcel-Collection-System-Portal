<script>
    $(function() {
        'use strict'

        var ctx1 = document.getElementById('chartBar1').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: [
                    <?php
                    
                        $find_all_subjects = $connect->prepare("SELECT DISTINCT subject FROM subject_term_marks WHERE results_code IN (SELECT code FROM student_term_results WHERE term=? AND student IN (SELECT student_code FROM class_students WHERE class_code=? AND year=?))");
                        $find_all_subjects->execute([$current_term_code,$the_class_code,$current_term_year]);
                        while($row=$find_all_subjects->fetch(PDO::FETCH_ASSOC)){
                            $the_subject_code = $row["subject"];
                            
                            $find_subject_details = $connect->prepare("SELECT * FROM subjects WHERE code=?");
                            $find_subject_details->execute([$the_subject_code]);
                            while($row=$find_subject_details->fetch(PDO::FETCH_ASSOC)){
                                $the_subject_name = $row["name"];
                            }
                            
                            echo "'".$the_subject_name."',";
                                
                        }
                    
                        ?>

                ],
                datasets: [{
                        
                        data:[
                            <?php
                            $find_all_subjects = $connect->prepare("SELECT DISTINCT subject FROM subject_term_marks WHERE results_code IN (SELECT code FROM student_term_results WHERE term=? AND student IN (SELECT student_code FROM class_students WHERE class_code=? AND year=?))");
                            $find_all_subjects->execute([$current_term_code,$the_class_code,$current_term_year]);
                            while($row=$find_all_subjects->fetch(PDO::FETCH_ASSOC)){
                                $the_subject_code = $row["subject"];
                                
                                $calculate_avg_for_subject_performance_query = $connect->prepare("SELECT AVG(inclass) AS inclass_average_percentage FROM subject_term_marks WHERE subject=? AND results_code IN (SELECT code FROM student_term_results WHERE term=? AND student IN (SELECT student_code FROM class_students WHERE class_code=? AND year=?))");
                                $calculate_avg_for_subject_performance_query->execute([$the_subject_code,$current_term_code,$the_class_code,$current_term_year]);
                                while($row=$calculate_avg_for_subject_performance_query->fetch(PDO::FETCH_ASSOC)){
                                    $inclass_average_percentage = $row["inclass_average_percentage"];
                                }
                                
                                echo $inclass_average_percentage.",";
                            }
                            ?>
                        ],
                        backgroundColor: '#5368FA',
                        label: 'Overall Term InClass Avg %'
                    },
                    {
                     
                        data: [
                            <?php
                            $find_all_subjects = $connect->prepare("SELECT DISTINCT subject FROM subject_term_marks WHERE results_code IN (SELECT code FROM student_term_results WHERE term=? AND student IN (SELECT student_code FROM class_students WHERE class_code=? AND year=?))");
                            $find_all_subjects->execute([$current_term_code,$the_class_code,$current_term_year]);
                            while($row=$find_all_subjects->fetch(PDO::FETCH_ASSOC)){
                                $the_subject_code = $row["subject"];
                                
                                $calculate_avg_for_subject_performance_query = $connect->prepare("SELECT AVG(exam) AS exam_average_percentage FROM subject_term_marks WHERE subject=? AND results_code IN (SELECT code FROM student_term_results WHERE term=? AND student IN (SELECT student_code FROM class_students WHERE class_code=? AND year=?))");
                                $calculate_avg_for_subject_performance_query->execute([$the_subject_code,$current_term_code,$the_class_code,$current_term_year]);
                                while($row=$calculate_avg_for_subject_performance_query->fetch(PDO::FETCH_ASSOC)){
                                    $exam_average_percentage = $row["exam_average_percentage"];
                                }
                                
                                echo $exam_average_percentage.",";
                            }
                            ?>
                        ],
                        backgroundColor: '#7ebcff', // Adjust color as needed
                        label: 'Overall Term Exam Avg %'
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
        var datapie = {

            labels: ['Male Term Performance', 'Female Term Performance'],
            datasets: [{
                data: [<?php echo round($the_avarage_performance_male,2)?>, <?php echo round($the_avarage_performance_female,2);?>],
                backgroundColor: ['#7ebcff', '#5368FA', '#7ee5e5', '#fdbd88']
            }]
        };


        var datapie_employees = {

            labels: ['Male Employees', 'Female Employees'],
            datasets: [{
                data: [9, 8],
                backgroundColor: ['#7ebcff', '#5368FA']
            }]
        };

        var datapie_class_students = {

            labels: ['Male Students', 'Female Students'],
            datasets: [{
                data: [<?php echo $count_all_male_students;?>, <?php echo $count_all_female_students;?>],
                backgroundColor: ['#7ebcff', '#5368FA']
            }]
        };


        var datapie_students = {
            labels: ['Male Students', 'Female Students'],
            datasets: [{
                data: [5, 7],
                backgroundColor: ['#7ebcff', '#5368FA']
            }]
        };

        var datapie_student_realtime_attendance = {
            labels: ['Classes'],
            datasets: [{
                data: [<?php echo $realtime_attendance_for_class_percentage;?>],
                backgroundColor: ['#7ebcff', '#5368FA']
            }]
        };


        var datapie_student_billing = {

            labels: ['Paid Up Students', 'Not yet Paid Students'],
            datasets: [{
                data: [<?php echo $count_paid_up_students;?>,<?php echo $count_not_paid_up_students;?>],
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
        var ctx3 = document.getElementById('chartDonut_class_students');
        var myDonutChart = new Chart(ctx3, {
            type: 'doughnut',
            data: datapie_class_students,
            options: optionpie
        });

        



        var ctx4 = document.getElementById('chartDonut_student_billing');
        var myDonutChart = new Chart(ctx4, {
            type: 'doughnut',
            data: datapie_student_billing,
            options: optionpie
        });
        
        
        var ctx5 = document.getElementById('chartDonut_realtime_attendance');
        var myDonutChart = new Chart(ctx5, {
            type: 'doughnut',
            data: datapie_student_realtime_attendance,
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