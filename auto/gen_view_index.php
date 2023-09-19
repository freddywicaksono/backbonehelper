<?php
include('functions.php');
include('mods.php');
$lib = new Inflector();
$tbname = $_GET['table'];
$classname = ucfirst($tbname);
$pk = getPrimaryKey($conn, $tbname);
$unik = getUnique($conn, $tbname);
$total = getTotalFields($conn, $tbname);
$fields = getAllFieldName($conn, $dbname, $tbname);
$model = $lib->singularize($classname)."Model";
$cname = $lib->singularize($classname)."Controller";
$objek = $lib->singularize($tbname);
$simpan = "$".$objek."->save();";
$link = "$".$tbname."->links()";
$id="$".$objek."->id();";
$hapus = "$".$objek."->delete();";
$temp = "";
$slash = chr(92);
$view ="resources".$slash."views";
$arrow = "->";
$temp ="";
$temp .='
<?php
/*
Filename : '.$tbname.'/index.php
Tools: BackBoneHelper
Framework : Backbone.js
Author : Freddy Wicaksono, M.Kom
*/
include("../layouts/header.php");
?>
    
    <div class="container">
        <div class="page-header">
        <h1>Data '.$classname.'</h1>
        </div>

        <div class="panel panel-default">
            <div class="panel-body" id="primary-content">
                <!-- this is content -->
            </div>
        </div>
        <button style="margin:10px 0;" class="btn btn-warning" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-desktop"></i> Show Output JSON</button>
        <div class="collapse" id="collapseExample">
            <code id="output" style="display:block;white-space:pre-wrap;"></code>
        </div>
    </div>

    <script type="text/jst" id="formTemplate">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="alert alert-danger fade in" style="display:none;"></div>
                <form>
                    <h2><%= name %></h2>
                    <div class="form-group">
                        <label>ID:</label>
                        <input type="text" class="form-control <%= _.isEmpty(id) ? \'myid\' : \'\' %>" name="id" value="<%= id %>" readonly />
                    </div>
';
$i=1;
foreach ($fields as $field) {
    if($field<>$pk){
        if($i<=$total-1){
            $temp .= "                    <div class=\"form-group\">
                        <label>$field:</label>
                        <input type=\"text\" class=\"form-control\" name=\"$field\" value=\"<%= $field %>\" />
                    </div>\n";
        }
        $i++; 
    }         
}

 $temp .='                   
                    <button class="save btn btn-large btn-info" type="submit">Save</button>
                    <a href="#index" class="btn btn-large btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </script>

    <script type="text/jst" id="deleteformTemplate">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="alert alert-danger fade in" style="display:none;"></div>
                <form>
                    <h2><%= name %></h2>
                    
                    <div class="form-group">
                        <label>ID:</label>
                        <input type="text" class="form-control <%= _.isEmpty(id) ? \'myid\' : \'\' %>" name="id" value="<%= id %>" readonly />
                    </div>
';
$i=1;
foreach ($fields as $field) {
    if($field<>$pk){
        if($i<=$total-1){
            $temp .= "                    <div class=\"form-group\">
                        <label>$field:</label>
                        <input type=\"text\" class=\"form-control\" name=\"$field\" value=\"<%= $field %>\" disabled/>
                    </div>\n";
        }
        $i++; 
    }         
}

$temp .='                    
                    <a class="btn btn-large btn-danger" href="#<%= id %>/delete"><i class="fa fa-trash"></i> Delete</a>
                    <a href="#index" class="btn btn-large btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </script>

    <!-- the index container -->
    <script type="text/template" id="indexTemplate">

        <a style="margin:10px 0px;" class="btn btn-large btn-info" href="#new"><i class="fa fa-plus"></i> Create New Data</a>
        <a data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2" style="margin:10px 0px;" class="btn btn-large btn-success" href="#index"><i class="fa fa-list"></i> View Data (Double Click)</a>

        <div class="collapse" id="collapseExample2">
        <% if (_.isEmpty(cruds)){ %>
        <div class="alert alert-warning">
            <p>There are currently no cruds. Try creating some.</p>
        </div>
        <% } %>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
';
$i=1;
foreach ($fields as $field) {
    if($i<=$total){
        $temp .= "                    <th>$field</th>\n";
    }
    $i++;        
}
                   
$temp .='
                    <th width="140">Action</th>
                </tr>
            </thead>
            <tbody>
                <% _.each(cruds, function (crud) { %>
                <tr>
';
$i=1;
foreach ($fields as $field) {
    if($i<=$total){
        $temp .= "          <td><%= crud.$field %></td>\n";
    }
    $i++;        
}

$temp .='
                    <td class="text-center">
                        <a class="btn btn-xs btn-info" href="#<%= crud.'.$pk.' %>/edit"><i class="fa fa-pencil"></i> Edit</a>
                        <a class="btn btn-xs btn-danger" href="#<%= crud.'.$pk.' %>/deleteform"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                </tr>
                <% }); %>
            </tbody>
        </table>
        </div>

    </script>

<?php
include("../layouts/footer.php");
?>
    
    
    <script src="../Models/'.$classname.'.js"></script>

  </body>
</html>
';

echo printCode($temp);

$folderPath = '../'.$tbname; 

if (!file_exists($folderPath) || !is_dir($folderPath)) {
    // Check if the folder does not exist or is not a directory
    if (mkdir($folderPath, 0755, true)) {
        echo "The folder was created successfully.\n";
        // File path
        $filePath = '../'.$tbname.'/index.php';

        // Save the text to the file
        file_put_contents($filePath, $temp);

        // Check if the text was successfully saved
        if (file_exists($filePath)) {
            echo "$tbname/index.php saved to file successfully!";
        } else {
            echo "Error saving text to file.";
        }
    } else {
        echo "Failed to create the folder.";
    }
} else {
    echo "The folder already exists.\n";
    // File path
    $filePath = '../'.$tbname.'/index.php';

    if (file_exists($filePath)) {
        echo "File '$filePath' sudah ada.";
    } else {
        // Save the text to the file
        file_put_contents($filePath, $temp);

        // Check if the text was successfully saved
        if (file_exists($filePath)) {
            echo $filePath." saved to file successfully!";
        } else {
            echo "Error saving text to file.";
        }
    }
}
?>