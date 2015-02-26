<div class="container">
  <form class="form-horizontal" method="post" action="<?php echo ROOT_URL;?>/login/run">
<?php foreach($errors as $error) {
        echo '<div class="alert alert-danger" role="alert">';
        echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"> </span>';
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo '<span class="sr-only">Error: </span>';
        echo '<strong> Error: </strong>' . $error;
        echo '</div>';
        }
?>
      <h1 class="page-header"> Login form </h1>


        <div class="form-group">
          <div class="top10 col-sm-12">
            <label for="login" class="control-label col-sm-4">Nickname or email</label>
            <div class="col-sm-6">
              <input type="text" class="form-control col-sm-8" id="login"
               value="<?php if(isset($formArray['login'])) 
                                echo $formArray['login'];?>"
               name="login" placeholder="Nickname or email" >
            </div>
          </div>
          <div class="top10 col-sm-12">
            <label for="password" class="control-label col-sm-4">Password</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" id="password"
                 name="password" placeholder="Password"
                >
            </div>
          </div>
        </div>
          <div class="form-group">
            <div class="top10">
              <div class="col-xs-offset-5 col-xs-4">
                  <button type="submit" class="top10 btn col-sm-8 btn-primary">Login</button>
              </div>
            </div>
          </div>
    </form>
</div>
