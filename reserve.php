<?php
// TODO: validation

session_start();
if (!isset($_SESSION['userId'])) {
  header('location:login.php');
}

require("util/reserve_logic.php");

try {
  require 'connection.php';
  $db->beginTransaction();
  $bit_stmt = $db->prepare("SELECT timeslot FROM availability WHERE pid = ? AND date = ?");
  $bit_stmt->bindValue(1, $_POST['pid']);
  $bit_stmt->bindValue(2, $_POST['date']);
  $bit_stmt->execute();
  $r = $bit_stmt->fetch(PDO::FETCH_ASSOC)['timeslot'] ?? 0;
  $map = generateMap($r);
  if ($_POST['length'] > $map[$_POST['start']]) {
    die("INTERNAL ERROR");
  }
  // cursed code coming ahead
  $shift = $_POST['start'] - 8;
  $mask = ((2 ** $_POST['length']) - 1) << $shift;
  $new_timeslot = ($r | $mask) & ((2 ** 16) - 1);
  var_dump(decbin($new_timeslot));
  $update_stmt = $db->prepare("REPLACE INTO availability VALUES(?, ?, ?)");
  $update_stmt->bindValue(1, $_POST['pid']);
  $update_stmt->bindValue(2, $_POST['date']);
  $update_stmt->bindValue(3, $new_timeslot);
  if ($update_stmt->execute() == false) {
    die("INTERNAL ERROR 2");
  }

  // need to get session
  $rev_stmt = $db->prepare("INSERT INTO reservation VALUES(null, :uid, :pid, :date, :time, :hours, null)");
  $rev_stmt->bindValue(":uid", $_SESSION['userId']);
  $rev_stmt->bindValue(":pid", $_POST['pid']);
  $rev_stmt->bindValue(":date", $_POST['date']);
  $rev_stmt->bindValue(":time", $_POST['start']);
  $rev_stmt->bindValue(":hours", $_POST['length']);
  if ($rev_stmt->execute() == false) {
    die("INTERNAL ERROR 3");
  }
  $db->commit();
  echo ("OK");
  header('location:history.php');
} catch (PDOException $ex) {
  echo $ex->getMessage();
  $db->rollBack();
}
