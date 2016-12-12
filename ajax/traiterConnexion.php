<?php
session_start();
require_once '../data/pdoM2l.php';
$login = $_REQUEST['login'];
$mdp = $_REQUEST['mdp'];


$pdo= PdoM2l::getPdo();
$user=$pdo->getUser($login,$mdp);

if($user != NULL)
{
    $_SESSION['mrbs_users']=$user;
    $_SESSION['mrbs_users']['login']=$login;
    $_SESSION['mrbs_users']['mdp']=$mdp;
    
}

echo json_encode($user);
?>