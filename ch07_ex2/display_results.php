<?php
    // get the data from the form
    $investment = filter_input(INPUT_POST, 'investment', 
            FILTER_VALIDATE_FLOAT);
    $interest_rate = filter_input(INPUT_POST, 'interest_rate', 
            FILTER_VALIDATE_FLOAT);
    $years = filter_input(INPUT_POST, 'years', 
            FILTER_VALIDATE_INT);
    
    // sets action var value
    if (isset($_POST['yearly'])) {
        $action = 'yearly';
    }
    else if (isset ($_POST['monthly'])) {
        $action = 'monthly';
    }

    // validate investment
    if ($investment === FALSE ) {
        $error_message = 'Investment must be a valid number.'; 
    } else if ( $investment <= 0 ) {
        $error_message = 'Investment must be greater than zero.'; 
    // validate interest rate
    } else if ( $interest_rate === FALSE )  {
        $error_message = 'Interest rate must be a valid number.'; 
    } else if ( $interest_rate <= 0 ) {
        $error_message = 'Interest rate must be greater than zero.'; 
    // validate years
    } else if ( $years === FALSE ) {
        $error_message = 'Years must be a valid whole number.';
    } else if ( $years <= 0 ) {
        $error_message = 'Years must be greater than zero.';
    } else if ( $years > 30 ) {
        $error_message = 'Years must be less than 31.';
    // set error message to empty string if no invalid entries
    } else {
        $error_message = ''; 
    }

    // if an error message exists, go to the index page
    if ($error_message != '') {
        include('index.php');
        exit();
    }

    // calculate the future value
    if ($action == 'yearly') {   
        $future_value = $investment;
        for ($i = 1; $i <= $years; $i++) {
            $future_value += $future_value * $interest_rate *.01;
        }
        $projection = 'yearly';
    }
    if ($action == 'monthly') {
        $number_of_months = $years * 12;
        $monthly_rate = round($interest_rate / 12, 1);
        $monthly_future_value = array();
        $future_value = $investment;
        for ($i = 0; $i <= $number_of_months; $i++) {
            $future_value += $future_value * $monthly_rate *.01;
            $monthly_future_value[$i] = $future_value;
        }
    }
    // apply currency and percent formatting
    $investment_f = '$'.number_format($investment, 2);
    $yearly_rate_f = $interest_rate.'%';
    $future_value_f = '$'.number_format($future_value, 2);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Future Value Calculator</title>
    <link rel="stylesheet" type="text/css" href="main.css"/>
</head>
<body>
    <main>
        <h1>Future Value Calculator</h1>

        <label>Investment Amount:</label>
        <span><?php echo $investment_f; ?></span><br>

        <?php if($action == "yearly") : ?>
            <label>Yearly Interest Rate:</label>
            <span><?php echo $yearly_rate_f; ?></span><br>
        
            <label>Number of Years:</label>
            <span><?php echo $years; ?></span><br>
        
            <label>Future Value:</label>
            <span><?php echo $future_value_f; ?></span><br>
        <?php endif; ?>
            
        <?php if ($action == 'monthly') : ?>
            <label>Monthly Interest Rate:</label>
            <span><?php echo($monthly_rate.'%'); ?></span><br>
            
            <label>Number of Months:</label>
            <span><?php echo $number_of_months; ?></span><br>
            
            <label>Future Value (Calculated Monthly):</label>
            <span><?php echo('$'.number_format($monthly_future_value[count($monthly_future_value) - 1], 2)) ?></span><br>
            
            <?php for ($i = 0; $i < count($monthly_future_value); $i++) : ?>
                <label>Month <?php print($i + 1); ?> Future Value</label>
                <span><?php echo '$'.number_format($monthly_future_value[$i], 2); ?></span><br>
            <?php endfor; ?>
        <?php endif; ?>
    </main>
</body>
</html>