<?php $disable = Session::get('userId') != $userId;?>
<?php if ($disable): ?>
<h1 class="page-header">View Profile</h1>
<?php else: ?>
<h1 class="page-header">Edit Profile</h1>
<?php endif;?>
<?php require('views/dashboard/index.php');?>

  <form class="form-horizontal" method="post" action="<?php echo ROOT_URL;?>/dashboard/updateProfile">

<?php if (isset($errors) && !empty($errors)) {

     foreach($errors as $error) {
        echo '<div class="alert alert-danger" role="alert">';
        echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"> </span>';
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo '<span class="sr-only">Error: </span>';
        echo '<strong> Error: </strong>' . $error;
        echo '</div>';
     }
}?>

      <div class="form-group top10">
        <h4 class="col-xs-offset-1 lead">Personal details</h4>
      </div>

        <div class="form-group">
          <div class="top10 col-sm-12 col-md-6">
            <label for="nickname" class="control-label col-sm-4">Nickname</label>
            <div class="col-sm-8">
              <input type="text" class="form-control col-sm-8" id="nickname"
               value="<?php if(isset($formArray['nickname'])) 
                            echo $formArray['nickname'];?>"
               name="nickname" disabled placeholder="Nickname" >
            </div>
          </div>
            <div class="top10 col-xs-12 col-md-6">
              <label for="surname" class="col-sm-4 control-label">Surname</label>
                <div class="input-group col-xs-12 col-sm-8 col-md-8">
                <select name="title" id="title" class="form-control"
                        style="margin-left: 3.5%; width: 25%;"
                        <?php if ($disable) echo 'disabled'; ?>>
                    <option value="Mr." 
                    <?php if (isset($formArray['title']) 
                              && (empty($formArray['title']) || $formArray['title'] == 'Mr.'))
                                  echo 'selected="selected"';?>>Mr.</option>
                    <option value="Mrs." 
                    <?php if (isset($formArray['title']) && $formArray['title'] == 'Mrs.') 
                                 echo 'selected="selected"';?>>Mrs.</option>
                    <option value="Ms." 
                    <?php if (isset($formArray['title']) && $formArray['title'] == 'Ms.') 
                                 echo 'selected="selected"';?>>Ms.</option>
                    <option value="Miss." 
                    <?php if (isset($formArray['title']) && $formArray['title'] == 'Miss.') 
                                 echo 'selected="selected"';?>>Miss.</option>
                    <option value="Dr." 
                    <?php if (isset($formArray['title']) && $formArray['title'] == 'Dr.') 
                                 echo 'selected="selected"';?>>Dr.</option>
                  </select>
                <input type="text" class="form-control" style="width: 67%;" id="surname" value=
                "<?php if (isset($formArray['surname']))
                           echo $formArray['surname'];?>"
                      <?php if ($disable) echo 'disabled'; ?>
                  name="surname" placeholder="Surname"
>
               </div>
            </div>

          <div class="top10 col-sm-12 col-md-6">
            <label for="firstName" class="control-label col-sm-4">First name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="firstName" value=
                "<?php if (isset($formArray['firstName']))
                           echo $formArray['firstName'];?>"
                      <?php if ($disable) echo 'disabled'; ?>
                  name="firstName" placeholder="First Name">
            </div>
          </div>
          <div class="top10 col-sm-12 col-md-6">
            <label for="middleName" class="control-label col-sm-4">Middle name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="middleName" value=
                "<?php if (isset($formArray['middleName']))
                           echo $formArray['middleName'];?>"
                      <?php if ($disable) echo 'disabled'; ?>
                  name="middleName" placeholder="Middle Name">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="top10 col-sm-12 col-md-6">
            <label for="email" class="control-label col-sm-4">E-mail</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="email" value=
                "<?php if (isset($formArray['email']))
                           echo $formArray['email'];?>"
                      <?php if ($disable) echo 'disabled'; ?>
                  name="email" placeholder="E-mail">
            </div>
          </div>
          <div class="top10 col-sm-12 col-md-6">
            <label for="phone" class="control-label col-sm-4">Phone number</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="phone" value=
                "<?php if (isset($formArray['phone']))
                            echo $formArray['phone'];?>"
                      <?php if ($disable) echo 'disabled'; ?>
                  name="phone" placeholder="Phone number">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="top10 col-sm-12 col-md-6">
            <label for="password" class="control-label col-sm-4">Password</label>
            <div class="col-sm-8">
                <input type="password" class="form-control" id="password"
                      <?php if ($disable) echo 'disabled'; ?>
                 name="password" placeholder="Password"
                >
            </div>
          </div>
          <div class="top10 col-sm-12 col-md-6">
            <label for="confirmPassword" class="control-label col-sm-4">Confirm Password</label>
            <div class="col-sm-8">
                <input type="password" class="form-control" id="confirmPassword"
                      <?php if ($disable) echo 'disabled'; ?>
                 name="confirmPassword" placeholder="Password"
                >
            </div>
          </div>
        </div>
        

        <div class="form-group top10">
            <h4 class="col-xs-offset-1 lead">Address details</h4>
        </div>

        <div class="form-group">
          <div class="top10 col-sm-12 col-md-6">
            <label for="city" class="control-label col-sm-4">City</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="city" value=
                "<?php if (isset($formArray['city']))
                           echo $formArray['city'];?>"
                      <?php if ($disable) echo 'disabled'; ?>
                  name="city" placeholder="City">
            </div>
          </div>
          <div class="top10 col-sm-12 col-md-6">
            <label for="country" class="control-label col-sm-4">Country</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="country" value=
                "<?php if (isset($formArray['country']))
                           echo $formArray['country'];?>"
                      <?php if ($disable) echo 'disabled'; ?>
                  name="country" placeholder="Country">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="top10 col-sm-12 col-md-12">
            <label for="addressLine1" class="control-label col-sm-4 col-md-2">Address Line 1</label>
            <div class="col-sm-8 col-md-10">
                <input type="text" class="form-control" id="addressLine1" value=
                "<?php if (isset($formArray['addressLine1']))
                           echo $formArray['addressLine1'];?>"
                      <?php if ($disable) echo 'disabled'; ?>
                  name="addressLine1" placeholder="Address Line 1">
            </div>
          </div>
          <div class="top10 col-sm-12">
            <label for="addressLine2" class="control-label col-md-2 col-sm-4">Address Line 2</label>
            <div class="col-sm-8 col-md-10">
                <input type="text" class="form-control" id="addressLine2" value=
                "<?php if (isset($formArray['addressLine2']))
                           echo $formArray['addressLine2'];?>"
                      <?php if ($disable) echo 'disabled'; ?>
                  name="addressLine2" placeholder="Address Line 2">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="top10 col-sm-12 col-md-6">
            <label for="county" class="control-label col-sm-4">County</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="county" value=
                "<?php if (isset($formArray['county']))
                           echo $formArray['county'];?>"
                      <?php if ($disable) echo 'disabled'; ?>
                  name="county" placeholder="County">
            </div>
          </div>
          <div class="top10 col-sm-12 col-md-6">
            <label for="postCode" class="control-label col-sm-4">Post code</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" value=
                "<?php if (isset($formArray['postCode']))
                           echo $formArray['postCode'];?>"
                      <?php if ($disable) echo 'disabled'; ?>
                   id="postCode" name="postCode" placeholder="Post code">
            </div>
          </div>
        </div>
        <div class="form-group">
            <h4 class="col-xs-offset-1 lead">Payment details</h4>
        </div>

        <div class="form-group top10">
          <div class="col-sm-12">
            <label for="paypalEmail" class="control-label col-md-2 col-sm-4">PayPal Email</label>
            <div class="col-sm-8 col-md-10">
                <input type="text" class="form-control" id="paypalEmail" value=
                "<?php if (isset($formArray['PayPalEmail']))
                            echo $formArray['PayPalEmail'];?>"
                      <?php if ($disable) echo 'disabled'; ?>
                  name="paypalEmail" placeholder="PayPal Email">
            </div>
          </div>
        </div>
        <?php if (!$disable): ?>
          <div class="form-group">
            <div class="top10">
              <div class="col-xs-offset-5 col-xs-4">
                  <button type="submit" class="top10 btn col-sm-8 btn-primary">Update profile</button>
              </div>
            </div>
          </div>
        <?php endif; ?>
    </form>
