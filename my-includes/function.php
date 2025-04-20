<?php 
function setBalance($amount, $process, $accountno)
{
    $con = new mysqli('localhost', 'root', '', 'bankify');
    $array = $con->query("SELECT * FROM useraccounts WHERE accountno='$accountno'");
    $row = $array->fetch_assoc();
    if ($process == 'credit') {
        $deposit = $row['deposit'] + $amount;
        return $con->query("UPDATE useraccounts SET deposit = '$deposit' WHERE accountno = '$accountno'");
    } else {
        $deposit = $row['deposit'] - $amount;
        return $con->query("UPDATE useraccounts SET deposit = '$deposit' WHERE accountno = '$accountno'");
    }
}

function setOtherBalance($amount, $process, $accountno)
{
    $con = new mysqli('localhost', 'root', '', 'bankify');
    $array = $con->query("SELECT * FROM otheraccounts WHERE accountno='$accountno'");
    $row = $array->fetch_assoc();
    if ($process == 'credit') {
        $deposit = $row['deposit'] + $amount;
        return $con->query("UPDATE otheraccounts SET deposit = '$deposit' WHERE accountno = '$accountno'");
    } else {
        $deposit = $row['deposit'] - $amount;
        return $con->query("UPDATE otheraccounts SET deposit = '$deposit' WHERE accountno = '$accountno'");
    }
}

function makeTransaction($action, $amount, $other)
{
    $con = new mysqli('localhost', 'root', '', 'bankify');
    if ($action == 'transfer') {
        return $con->query("INSERT INTO transaction (action, debit, other, userid) VALUES ('transfer', '$amount', '$other', '$_SESSION[userid]')");
    }
    if ($action == 'withdraw') {
        return $con->query("INSERT INTO transaction (action, debit, other, userid) VALUES ('withdraw', '$amount', '$other', '$_SESSION[userid]')");
    }
    if ($action == 'deposit') {
        return $con->query("INSERT INTO transaction (action, credit, other, userid) VALUES ('deposit', '$amount', '$other', '$_SESSION[userid]')");
    }
}

function makeTransactionCashier($action, $amount, $other, $userid)
{
    $con = new mysqli('localhost', 'root', '', 'bankify');
    if ($action == 'transfer') {
        return $con->query("INSERT INTO transaction (action, debit, other, userid) VALUES ('transfer', '$amount', '$other', '$userid')");
    }
    if ($action == 'withdraw') {
        return $con->query("INSERT INTO transaction (action, debit, other, userid) VALUES ('withdraw', '$amount', '$other', '$userid')");
    }
    if ($action == 'deposit') {
        return $con->query("INSERT INTO transaction (action, credit, other, userid) VALUES ('deposit', '$amount', '$other', '$userid')");
    }
}
?>