<div class="container">

  <h1 class="page-header"> Open new auction </h1>

  <div class="row">
  <form id="fileupload" class="form-horizontal" method="post" action="<?php echo ROOT_URL;?>/newAuction/run">

    <div class="col-sm-6">
      <div class="form-group">
        <div class="top10 col-sm-12">
          <label for="itemName" class="control-label col-sm-4">Item name</label>
          <div class="col-sm-8">
              <input type="text" class="form-control" id="itemName" value=
              "<?php if (isset($formArray['itemName']))
                         echo $formArray['itemName'];?>"
                name="itemName" placeholder="Item name">
          </div>
        </div>
        <div class="top10 col-sm-12">
          <label for="category" class="control-label col-sm-4">Category</label>
          <div class="col-sm-8">
              <select id="category" class="form-control">
                <option value="1"> 1 </option>
                <option value="2"> 2 </option>
              </select>
          </div>
        </div>

        <div class="top10 col-sm-12">
          <label for="auctionType" class="control-label col-sm-4">Auction Type</label>
          <div class="col-sm-8">
              <select id="auctionType" class="form-control">
                <option value="1"> English Auction </option>
                <option value="2"> Dutch Auction </option>
                <option value="3"> English Auction with hidden bids </option>
                <option value="4"> Vickery Auction </option>
                <option value="5"> Buy it now </option>
              </select>
          </div>
        </div>

        <div class="top10 col-sm-12">
          <label for="startPrice" class="control-label col-sm-4">Start price</label>
          <div class="col-sm-8">
              <input type="text" class="form-control" id="startPrice" value=
              "<?php if (isset($formArray['startPrice']))
                         echo $formArray['startPrice'];?>"
                name="itemName" placeholder="Start Price">
          </div>
        </div>
      </div>
    </div>


    <div class="col-sm-6">
      <div class="form-group">
        <label for="auctionType" class="control-label col-sm-4">Item description</label>
        <div class="col-sm-8">
          <textarea class="form-control" rows="8"></textarea>
        </div>
      </div>
    </div>
&nbsp;
    <div class="top10 fileupload-buttonbar">
      <div style="text-align:right; margin-right:15px" class="">
        <span class="btn btn-success fileinput-button">
          <i class="glyphicon glyphicon-plus"></i>
          <span>Add files...</span>
          <input type="file" name="files[]" multiple>
        </span>
        <button type="reset" class="btn btn-warning cancel">
          <i class="glyphicon glyphicon-ban-circle"></i>
          <span>Cancel upload</span>
        </button>
        <button type="submit" class="btn btn-primary start">
          <i class="glyphicon glyphicon-circle-arrow-right"></i>
          <span>Submit</span>
        </button>
        <span class="fileupload-process"></span>
      </div>
      <div class="col-lg-5 fileupload-progress fade">
        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
          <div class="progress-bar progress-bar-success" style="width:0%;"></div>
        </div>
        <div class="progress-extended">&nbsp;</div>
      </div>
    </div>
    <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
  </form>
</div>
</div>

<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button style="display:none" class="btn btn-primary start" disabled>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="public/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="public/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="public/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="public/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="public/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="public/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="public/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="public/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="public/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="public/js/main.js"></script>


