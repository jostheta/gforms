<!DOCTYPE html>
<html>
<head>
    <title>Form Responses</title>
    <link rel= "stylesheet" href = "<?= base_url() ?>assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Change align-items to flex-start to avoid centering */
            height: 100vh;
            margin: 0;
            font-family: Roboto, sans-serif;
            background-color: #f0ebf8;
            overflow-y: auto; /* Ensure vertical scrolling is enabled */
        }
        .container {
            width: 90%;
            max-width: 700px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px 0; /* Add margin to the top and bottom to provide space around the container */
        }
        .question-box {
            margin-bottom: 20px;
            padding: 15px;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .question-title {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }
        .chart-container {
            margin-top: 30px;
            margin-bottom: 20px;
            width:300px;
            margin-left:200px;
            
        }
        .paragraph-answer {
            margin-bottom: 10px;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 4px;
        }
        .paragraph-answer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="text-align: center;">Form Responses</h1>
        <?php foreach ($data as $question_id => $question): ?>
            <div class="question-box">
                <h2 class="question-title"><?php echo $question['question_text']; ?></h2>
                <?php if ($question['question_type'] == 'multiple-choice'): ?>
                    <?php if (!empty($question['options'])): ?>
                        <div class="chart-container">
                            <canvas id="chart-<?php echo $question_id; ?>"></canvas>
                        </div>
                        <script>
                            var ctx = document.getElementById('chart-<?php echo $question_id; ?>').getContext('2d');
                            var chartData = {
                                labels: [],
                                datasets: [{
                                    label: 'Responses',
                                    data: [],
                                    backgroundColor: [],
                                    borderColor: [],
                                    borderWidth: 1
                                }]
                            };

                            var backgroundColors = [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ];
                            var borderColors = [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ];

                            var colorIndex = 0;

                            <?php foreach ($question['options'] as $option_text => $count): ?>
                                chartData.labels.push('<?php echo $option_text; ?>');
                                chartData.datasets[0].data.push(<?php echo $count; ?>);
                                chartData.datasets[0].backgroundColor.push(backgroundColors[colorIndex % backgroundColors.length]);
                                chartData.datasets[0].borderColor.push(borderColors[colorIndex % borderColors.length]);
                                colorIndex++;
                            <?php endforeach; ?>

                            var chart = new Chart(ctx, {
                                type: 'pie',
                                data: chartData
                            });
                        </script>
                    <?php endif; ?>
                <?php elseif ($question['question_type'] == 'checkbox'): ?>
                    <?php if (!empty($question['options'])): ?>
                        <div class="chart-container">
                            <canvas id="chart-<?php echo $question_id; ?>"></canvas>
                        </div>
                        <script>
                            var ctx = document.getElementById('chart-<?php echo $question_id; ?>').getContext('2d');
                            var chartData = {
                                labels: [],
                                datasets: [{
                                    label: 'Responses',
                                    data: [],
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            };

                            <?php foreach ($question['options'] as $option_text => $count): ?>
                                chartData.labels.push('<?php echo $option_text; ?>');
                                chartData.datasets[0].data.push(<?php echo $count; ?>);
                            <?php endforeach; ?>

                            var chart = new Chart(ctx, {
                                type: 'bar',
                                data: chartData,
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>
                    <?php endif; ?>
                <?php elseif ($question['question_type'] == 'paragraph'): ?>
                    <?php foreach ($question['answers'] as $answer): ?>
                        <div class="paragraph-answer">
                            <p>
                                <?php
                                    $words = explode(' ', $answer);
                                    echo implode(' ', array_slice($words, 0, 5));
                                    if (count($words) > 5) echo '...';
                                ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>