<?php
if(isset($_SESSION['userData'])){
   $s = $_SESSION['userData'];
}
?>
        <header>
            <h3>The Wall</h3>
            <a class='signIn' <?=(isset($s))?
"href='#' name='out'>Sign Out</a>"."\r\n" :
"href='php/signIn.php'>Sign In</a>";
?>

            <p class='user'><?=(isset($s))? 'Welcome '.$s['name'].' !':$s['name'] = false;?></p>
        </header>
