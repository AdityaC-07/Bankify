<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header('location:login.php');
    exit;
}

// Check if the userid matches the session userid for security
if (!isset($_GET['userid']) || $_GET['userid'] != $_SESSION['userid']) {
    die("Unauthorized access");
}

// Get the format parameter
$format = isset($_GET['format']) ? $_GET['format'] : 'pdf';

// Connect to database
$con = new mysqli('localhost', 'root', '', 'bankify');

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Get user data
$userId = $_SESSION['userid'];
$userData = $con->query("SELECT * FROM useraccounts WHERE id = '$userId'")->fetch_assoc();

// Get transactions
$transactions = [];
$result = $con->query("SELECT * FROM transaction WHERE userid = '$userId' ORDER BY date DESC");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
}

// Function to format transaction for output
function formatTransaction($transaction) {
    $date = date('Y-m-d H:i:s', strtotime($transaction['date']));
    $description = '';
    $amount = 0;
    $type = '';
    
    if ($transaction['action'] == 'withdraw') {
        $description = 'Withdrawal';
        $amount = -$transaction['debit'];
        $type = 'Debit';
    } else if ($transaction['action'] == 'deposit') {
        $description = 'Deposit';
        $amount = $transaction['credit'];
        $type = 'Credit';
    } else if ($transaction['action'] == 'deduction') {
        $description = 'Deduction: ' . $transaction['other'];
        $amount = -$transaction['debit'];
        $type = 'Debit';
    } else if ($transaction['action'] == 'transfer') {
        $description = 'Transfer to account: ' . $transaction['other'];
        $amount = -$transaction['debit'];
        $type = 'Debit';
    }
    
    return [
        'date' => $date,
        'description' => $description,
        'amount' => $amount,
        'type' => $type
    ];
}

// Generate appropriate output based on format
switch ($format) {
    case 'pdf':
        generatePDF($userData, $transactions);
        break;
    case 'excel':
        generateExcel($userData, $transactions);
        break;
    case 'csv':
        generateCSV($userData, $transactions);
        break;
    default:
        die("Invalid format specified");
}

// PDF Generation
function generatePDF($userData, $transactions) {
    // For a real implementation, you would use a library like FPDF or TCPDF
    // This is a simplified placeholder function
    
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="bank_statement.pdf"');
    
    // In a real implementation, you would generate a PDF here
    // Since we can't include a PDF library in this example, we'll just output some text
    echo "This would be a PDF bank statement for " . $userData['name'] . "\n\n";
    echo "Account Number: " . $userData['accountno'] . "\n";
    echo "Statement Date: " . date('Y-m-d') . "\n\n";
    echo "Transactions:\n";
    
    foreach ($transactions as $transaction) {
        $formattedTransaction = formatTransaction($transaction);
        echo $formattedTransaction['date'] . " | " . 
             $formattedTransaction['description'] . " | " . 
             $formattedTransaction['type'] . " | Rs." . 
             number_format(abs($formattedTransaction['amount']), 2) . "\n";
    }
}

// Excel Generation
function generateExcel($userData, $transactions) {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="bank_statement.xls"');
    
    echo "Account Name\tAccount Number\tStatement Date\n";
    echo $userData['name'] . "\t" . $userData['accountno'] . "\t" . date('Y-m-d') . "\n\n";
    
    echo "Date\tDescription\tType\tAmount (Rs.)\n";
    
    foreach ($transactions as $transaction) {
        $formattedTransaction = formatTransaction($transaction);
        echo $formattedTransaction['date'] . "\t" . 
             $formattedTransaction['description'] . "\t" . 
             $formattedTransaction['type'] . "\tRs." . 
             number_format(abs($formattedTransaction['amount']), 2) . "\n";
    }
}

// CSV Generation
function generateCSV($userData, $transactions) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="bank_statement.csv"');
    
    $output = fopen('php://output', 'w');
    
    // User information
    fputcsv($output, ["Account Name", "Account Number", "Statement Date"]);
    fputcsv($output, [$userData['name'], $userData['accountno'], date('Y-m-d')]);
    fputcsv($output, []); // Empty line
    
    // Column headers
    fputcsv($output, ["Date", "Description", "Type", "Amount (Rs.)"]);
    
    // Transactions
    foreach ($transactions as $transaction) {
        $formattedTransaction = formatTransaction($transaction);
        fputcsv($output, [
            $formattedTransaction['date'],
            $formattedTransaction['description'],
            $formattedTransaction['type'],
            "Rs." . number_format(abs($formattedTransaction['amount']), 2)
        ]);
    }
    
    fclose($output);
}
