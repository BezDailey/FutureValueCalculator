<?php 
    //set default value of variables for initial page load
    //if (!isset($investment)) { $investment = '10000'; } 
    if (!isset($interest_rate)) { $interest_rate = '5'; } 
    if (!isset($years)) { $years = '5'; } 
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
    <?php if (!empty($error_message)) { ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php } // end if ?>
    <form action="display_results.php" method="post">
        <input type="hidden" name="action" value="yearly"/>
        <div id="data">
            <label>Investment Amount:</label>
            <select name="investment">
                <?php for ($investment = 10000; $investment < 50001; $investment += 5000) : ?>
                    <option value="<?php echo $investment; ?>"><?php echo '$'.number_format($investment, 2); ?></option>
                <?php endfor; ?>
            </select><br>
            
            <label>Yearly Interest Rate:</label>
            <select name="interest_rate">
                <?php for ($interest_rate = 4; $interest_rate < 12.1; $interest_rate += .5) : ?>
                <option value="<?php echo $interest_rate; ?>"><?php echo $interest_rate.'%'; ?></option>
                <?php endfor; ?>
            </select><br>

            <label>Number of Years:</label>
            <input type="text" name="years"value="<?php echo $years; ?>"/><br>
        </div>

        <div id="buttons">
            <label>&nbsp;</label>
            <input type="submit" name="yearly" value="Calculate"/>
            <input type="submit" name="monthly" value="Compound Interest Monthly"/>
        </div>

    </form>
    </main>
</body>
</html>