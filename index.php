<?php
    //Session startup
    session_start();
?>
<title>Sign student list</title>
<h1>[Sign student list]</h1>
<form action="index.php" method="GET" style="width: 100%; height: 30px; padding: 10px 0 10px 0; background:<?php if(isset($_GET['keyValueForEdit'])){ echo 'Green'; }else{echo 'Blue';}?>;">
    <a style="color: white;">&nbsp;&nbsp;[<?php if(isset($_GET['keyValueForEdit'])){ echo ' Edit mode: '; }else{echo ' Insert mode: ';}?>]&nbsp;&nbsp;</a>
    <input type="hidden" name="keyInput" value="<?php if(isset($_GET['keyValueForEdit'])){ echo $key = $_GET['keyValueForEdit']; } ?>" />
    <input type="text" name="firstname" placeholder="Type your firstname" <?php if(isset($_GET['keyValueForEdit'])){ $key = $_GET['keyValueForEdit']; echo "value='" . $_SESSION['data'][$key]['firstname'] . "'";} ?> />
    <input type="text" name="lastname" placeholder="Type your lastname" <?php if(isset($_GET['keyValueForEdit'])){ $key = $_GET['keyValueForEdit']; echo "value='" . $_SESSION['data'][$key]['lastname'] . "'";} ?>/>
    <select name="sex">
        <option <?php if(isset($_GET['keyValueForEdit'])){ $key = $_GET['keyValueForEdit']; if($_SESSION['data'][$key]['sex'] == 'Male'){ echo "selected='selected'"; }} ?>>Male</option>
        <option <?php if(isset($_GET['keyValueForEdit'])){ $key = $_GET['keyValueForEdit']; if($_SESSION['data'][$key]['sex'] == 'Female'){ echo "selected='selected'"; }} ?>>Female</option>
    </select>
    <input type="text" name="mail" placeholder="Type your mail" <?php if(isset($_GET['keyValueForEdit'])){ $key = $_GET['keyValueForEdit']; echo "value='" . $_SESSION['data'][$key]['mail'] . "'";} ?>/>
    <input type="text" name="phonenumber" placeholder="Type your phone number" <?php if(isset($_GET['keyValueForEdit'])){ $key = $_GET['keyValueForEdit']; echo "value='" . $_SESSION['data'][$key]['phonenumber'] . "'";} ?>/>
    <input type="submit" name="buttonSubmitForm" value="<?php if(isset($_GET['keyValueForEdit'])){ echo 'Edit'; }else{echo 'Add';}?>"/>
    <?php if(isset($_GET['keyValueForEdit'])){ echo "<button>Cancel</button>"; } ?>
    
</form>
<?php
    //Test if input value are empty or not
    if(empty($_GET['firstname']) AND empty($_GET['lastname']) AND empty($_GET['phonenumber'])){
        echo "<center style='color: red;'>&nbsp;<<< Please fill all the blank field !!! >>></center>";
    }else{
        
        switch($_GET['buttonSubmitForm']){
            case 'Add':
                //Store each input into session
                $_SESSION['firstname'] = $_GET['firstname'];
                $_SESSION['lastname'] = $_GET['lastname'];
                $_SESSION['sex'] = $_GET['sex'];
                $_SESSION['mail'] = $_GET['mail'];
                $_SESSION['phonenumber'] = $_GET['phonenumber'];
                $_SESSION['history'] = date(h).":".date(i) . " " . date(d)."/".date(M)."/".date(y);
                //Creation of a little database with session
                // 'firstname' => $_SESSION['firstname'] for EXAMPLE is like: 
                //  key => value
                $_SESSION['data'][] = array('firstname' => $_SESSION['firstname'],
                                          'lastname' => $_SESSION['lastname'],
                                          'sex' => $_SESSION['sex'],
                                          'mail' => $_SESSION['mail'],
                                          'phonenumber' => $_SESSION['phonenumber'],
                                          'history' => $_SESSION['history']
                                          );
                break;
            case 'Edit':
                //Edit Session with there key
                $keyIn = $_GET['keyInput'];
                $_SESSION['data'][$keyIn]['firstname'] = $_GET['firstname'];
                $_SESSION['data'][$keyIn]['lastname'] = $_GET['lastname'];
                $_SESSION['data'][$keyIn]['sex'] = $_GET['sex'];
                $_SESSION['data'][$keyIn]['mail'] = $_GET['mail'];
                $_SESSION['data'][$keyIn]['phonenumber'] = $_GET['phonenumber'];
                $_SESSION['data'][$keyIn]['history'] = date(h).":".date(i) . " " . date(d)."/".date(M)."/".date(y);
                break;
            default:
                break;
        }
                    
    }
?>
<hr/>
&nbsp;<a href="index.php?clearTable=true">Clear table</a> <>
<a href="index.php?savepdf=true">Save into PDF</a> <>
<a href="index.php?savejson=true">Save into JSON</a>
<hr/>
<table border="1" width="100%" style="text-align: center;">
    <tr>
        <td><b>---</b></td>
        <td><b>Firstname</b></td>
        <td><b>Lastname</b></td>
        <td><b>Sex</b></td>
        <td><b>Mail</b></td>
        <td><b>Phone Number</b></td>
        <td><b>Register history</b></td>
        <td>&nbsp;</td>
    </tr>
<?php
    //Create a loop to access our little database in session
    foreach($_SESSION['data'] as $key => $value) {
        echo "<tr>";
            echo "<td>" . $i += 1 . "</td>";
            echo "<td>" . $value['firstname'] . "</td>";
            echo "<td>" . $value['lastname'] . "</td>";
            echo "<td>" . $value['sex'] . "</td>";
            echo "<td>" . $value['mail'] . "</td>";
            echo "<td>" . $value['phonenumber'] . "</td>";
            echo "<td>" . $value['history'] . "</td>";
            echo "<td><a href='index.php?keyValueForEdit=" . $key . "'>Edit</a> <> <a href='index.php?keyValueForDelete=" . $key . "'>Delete</a></td>";
        echo "</tr>";
    }
    
    
?>
</table>
<hr/>
&nbsp;by <a href=''>Ralph Alex Charlemagne</a>&copy;
<hr/>
<?php
    //Destroy session
    if(isset($_GET['clearTable']) AND $_GET['clearTable'] == true) {
        session_destroy();
        header("Location: index.php");
    }
    
    if(isset($_GET['keyValueForEdit'])) {
        
    }
    
    if(isset($_GET['keyValueForDelete'])) {
        $key = $_GET['keyValueForDelete'];
        unset($_SESSION['data'][$key]);
        header("Location: index.php");
    }
?>