<!--
Sources:
https://www.javatpoint.com/php-adding-two-numbers 
https://www.w3schools.blog/php-program-to-create-a-simple-calculator
https://dev.to/dcodeyt/creating-beautiful-html-tables-with-css-428l
-->

<?php
    $url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    ini_set('display_errors', 0);
    
    // Check if user presses the calculate button
    if(isset( $_REQUEST['calculate'] )) {

        // Get the operator and the two numbers from the fourm 
        $operator=$_REQUEST['operator'];
        $num1 = $_REQUEST['val1'];
        $num2 = $_REQUEST['vAal2'];
        
        // Check if the inputted number valies are invalid
        if($_REQUEST['val1']==NULL || $_REQUEST['val2']==NULL) {
            exit;
        }

        // determine the operator and update the result var

        if($operator=="+"){
            $result= $num1+$num2;
        }
        
        if($operator=="-"){
            $result= $num1-$num2;
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <a class = "link" href = <?php echo str_replace("Team104/dawoud/", "", $url) ?>><h1 class = "sectionText">104</h1></a>
        <title>Dawoud Husain</title>
    </head>


    <body>
        <link rel="stylesheet" type="text/css" href="styles.css">

        <div class="logo">
            <img src = "dawoud-logo.png" alt="Dawoud's buissness logo" />
            <h2>Hello, my name is Dawoud Husain</h2>
            <h6>I am a fourth year software engineering studnet and one of the group members of this project</h6>

        <div>
      
        <h2>Check Out This PHP Calculator</h2>
        <form>
            <table>
                <tr>
                    <td>Num1</td>
                    <td colspan="1">
                    <input name="val1" type="text"/></td>
                </tr>
                
                <tr>
                    <td >Num2</td>
                    <td class="auto-style5">
                    <input name="val2" type="text" ></td> 
                </tr>

                <tr>
                    <td>Operator</td>
                    <td>
                        <select name="operator">
                            <option>+</option>
                            <option>-</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td></td>
                    <td><input type="submit" name="calculate" value="Calculate" /></td>	 
                </tr>
                
                <tr>
                    <td>Result: </td>
                    <td><?php echo $result;?></td>
                </tr>
            </table>
        </form>
    </body>
</html>
