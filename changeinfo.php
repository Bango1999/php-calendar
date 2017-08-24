<?php
// Ajax calls this REGISTRATION code to execute (run when the whole form filled)
$title = "Change Information";
include "includes/init.php";
    $check=0;
include_once 'includes/auth.php';

if (!empty($_POST)) {

    // NGHIA'S NOTE: fill in the SESSION array
    if ($_POST['modify'] == "true") {
        $_SESSION['name'] = $_POST['name'];
        $newname= $_POST['name'];
        $_SESSION['work'] = $_POST['work'];
        $_SESSION['phone'] = $_POST['phone'];
        $_SESSION['gender'] = $_POST['gender'];
        $_SESSION['phoneappear'] = $_POST['phoneappear'];
        $_SESSION['emailappear'] = $_POST['emailappear'];
        $_SESSION['country'] = $_POST['country'];
        $_SESSION['website'] = $_POST['website'];
	//mysqli_real_escape_string($variable);
        // update tables data
        $u= $_SESSION['username'];
        $w= $_SESSION['work'];
        $p= $_SESSION['phone'];
        $g= $_SESSION['gender'];
        $pa= $_SESSION['phoneappear'];
        $ea= $_SESSION['emailappear'] ;
        $c= $_SESSION['country'];
        $web= $_SESSION['website'];

        $sql = "UPDATE users SET name='$newname' WHERE username='$u' ";  $query = mysqli_query($db_conx, $sql);
        $sql = "UPDATE users SET gender='$g' WHERE username='$u' ";  $query = mysqli_query($db_conx, $sql);
        $sql = "UPDATE users SET emailappear='$ea' WHERE username='$u' ";  $query = mysqli_query($db_conx, $sql);
        $sql = "UPDATE users SET work='$w' WHERE username='$u' ";  $query = mysqli_query($db_conx, $sql);
        $sql = "UPDATE users SET phone='$p' WHERE username='$u' ";  $query = mysqli_query($db_conx, $sql);
        $sql = "UPDATE users SET phoneappear='$pa' WHERE username='$u' ";  $query = mysqli_query($db_conx, $sql);
        $sql = "UPDATE users SET country='$c' WHERE username='$u' ";  $query = mysqli_query($db_conx, $sql);
        $sql = "UPDATE users SET website='$web' WHERE username='$u' ";  $query = mysqli_query($db_conx, $sql);

        if ($query) {$check=1;}
    }

}

$debug='0';
if ($debug=='1') {
    echo $_SESSION['login']; echo "<br>";
    echo $_SESSION['userId']; echo "<br>";
    echo $_SESSION['username']; echo "<br>";
    echo $_SESSION['name']; echo "<br>";

    echo $_SESSION['email']; echo "<br>";
    echo $_SESSION['emailappear']; echo "<br>";
    echo $_SESSION['gender']; echo "<br>";
    echo $_SESSION['userlevel']; echo "<br>";
    echo $_SESSION['signup']; echo "<br>";
    echo $_SESSION['lastlogin']; echo "<br><br>";

    echo $_SESSION['avatar']; echo "<br>";
    echo $_SESSION['work']; echo "<br>";
    echo $_SESSION['phone']; echo "<br>";
    echo $_SESSION['phoneappear']; echo "<br>";
    echo $_SESSION['website']; echo "<br>";
    echo $_SESSION['country']; echo "<br><br>";

    echo $_COOKIE["user"]; echo "<br>";
}

?>
<!----------------------------------->
<!---  HTML page starts from here -->

    <center>
    <fieldset id="uploadpic" style= "display: inline;clear:center;float:center;width:450px;">
        <legend>Edit Basic information</legend>

        <table width="500" border="0" align="center" cellpadding="0" cellspacing="1">
            <form method="post" action="changeinfo.php" name="modifyform" id="modifyform" enctype="multipart/form-data">
                <tr height="30px">
                    <td width="280">Full name </td>
                    <td width="6">:</td>
                    <td width="320"><?php echo $_SESSION['name']; ?></td>
                </tr>
                <tr height="30px">
                    <td>Your gender</td>
                    <td>:</td>
                    <td><?php echo ($_SESSION['gender']=='m')?"Male":"Female"; ?></td>
                </tr>

                <tr height="30px">
                    <td>Work/Education place</td>
                    <td>:</td>
                    <td> <?php echo $_SESSION['work'];?> </td>
                </tr>
                <tr height="30px">
                    <td>Phone number</td>
                    <td>:</td>
                    <td><?php echo $_SESSION['phone']; ?></td>
                </tr>
                <tr height="30px">
                    <td>Email</td>
                    <td>:</td>
                    <td><?php echo $_SESSION['email'];    ?></td>
                </tr>
                <tr height="30px">
                    <td>Currently show phone number?</td>
                    <td>:</td>
                    <td><?php echo ($_SESSION['phoneappear']==1)?"yes":"no"; ?></td>
                </tr>
                <tr height="30px">
                    <td>Currently show email?</td>
                    <td>:</td>
                    <td><?php echo ($_SESSION['emailappear']==1)?"yes":"no"; ?></td>
                </tr>
                 <tr height="30px">
                    <td>Country </td>
                    <td>:</td>
                    <td><?php echo $_SESSION['country']; ?></td>
                </tr>
                <tr height="30px">
                    <td>Website</td>
                    <td>:</td>
                    <td><?php echo $_SESSION['website']; ?></td>
                </tr>

                <tr height="30px">
                    <td width="280"> * Change Full name </td>
                    <td width="6">?</td>
                    <td width="320"><input style="width: 200px; padding: 3px; background: #F3F9DD;" 
                        name="name" type="text"  value="<?php echo $_SESSION['name']; ?>"></td>
                </tr>
                <tr height="30px">
                    <td> * Change Gender</td>
                    <td>?</td>
                    <td><select name="gender">
                        <option value="m">Male</option>
                        <option value="f">Female</option>
                        </select></td>
                </tr>
                <tr height="30px">
                    <td>* Change Work/ Education place</td>
                    <td>?</td>
                    <td><input style="width: 200px; padding: 3px; background: #F3F9DD;" 
                        type="text" name="work"  maxlength="200" value="<?php echo $_SESSION['work']; ?>"></td>
                </tr>
                <tr height="30px">
                    <td>* Change phone number:</td>
                    <td>?</td>
                    <td><input style="width: 200px; padding: 3px; background: #F3F9DD;"
                        type="text"name="phone"  maxlength="20" value="<?php echo $_SESSION['phone']; ?>"></td>
                </tr>
                
                 <tr height="30px">
                    <td>* Show phone number to public</td>
                    <td>?</td>
                    <td><select name="phoneappear">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                        </select></td>
                </tr>                           
                <tr height="30px">
                    <td>* Show email to public</td>
                    <td>?</td>
                    <td> <select name="emailappear">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select></td>
                </tr>
                 <tr height="30px">
                    <td width="280"> * Change country </td>
                    <td width="6">?</td>
                    <td width="320"><input style="width: 200px; padding: 3px; background: #F3F9DD;"
                        name="country" type="text"  width="320px" maxlength="30" value="<?php echo $_SESSION['country']; ?>"></td>
                </tr>
                 <tr height="30px">
                    <td width="280"> * Change website </td>
                    <td width="6">?</td>
                    <td width="320"><input style="width: 200px; padding: 3px; background: #F3F9DD;"
                        name="website" type="text"  width="320px" maxlength="200" value="<?php echo $_SESSION['website']; ?>"></td>
                </tr>


                <tr height="70px">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>   <input type="hidden" name="modify" value="true" />
                        <input type="submit" id="update" style="font-size:18px; padding: 12px;" value="Update my profile!" /></td>
                </tr>
            </table>

          </form>
    </fieldset>
    </center>
    <br><br><br>
    <?php
if ($check == 1) {
?>
         <div style="margin-left: 200px">
            Successfully update your info!</div> 
    <?php }  ?>
           
           <br><br> <div style="margin-left: 200px"> <a href="user.php">
            Click here </a> to go back to the your User page.</div> <br>

<?php include_once "includes/footer.php"; ?>
