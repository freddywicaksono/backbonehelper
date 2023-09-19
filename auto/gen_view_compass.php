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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>CRUD BackboneJS PHP MySQL</title>

<link href="https://cdn.usebootstrap.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/css/bootstrap-material-datetimepicker.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" rel="stylesheet">
<!-- Bootstrap Select Css -->
<link href="../assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<!-- Custom Css -->
<link  rel="stylesheet" href="../assets/css/main.css">
<link rel="stylesheet" href="../assets/css/color_skins.css">
</head>
<body  class="theme-cyan">
<nav class="navbar">
    <div class="col-12">        
        <div class="navbar-header">
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="index.html" style="height:60px"><img src="../assets/images/simbol_umc.png" width="30" alt="Compass">
            <span class="m-l-10">SIAKAD</span></a>
        </div>
        <ul class="nav navbar-nav navbar-left">
            <li><a href="javascript:void(0);" class="ls-toggle-btn" data-close="true"><i class="zmdi zmdi-swap"></i></a></li>            
        </ul>
        <ul class="nav navbar-nav navbar-left">
            <li class="title">SISTEM INFORMASI AKADEMIK</li>
        </ul>
    </div>
</nav>
<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <div class="image"><a href="profile.html"><img src="../assets/images/profile_av.jpg" alt="User"></a></div>
                    <div class="detail">
                        <h4>nama</h4>
                        <small>email</small>                        
                    </div>
                    <a href="events.html" title="Events"><i class="zmdi zmdi-calendar"></i></a>
                    <a href="mail-inbox.html" title="Inbox"><i class="zmdi zmdi-email"></i></a>
                    <a href="contact.html" title="Contact List"><i class="zmdi zmdi-account-box-phone"></i></a>
                    <a href="chat.html" title="Chat App"><i class="zmdi zmdi-comments"></i></a>
                    <a href="logout.php" title="Sign out"><i class="zmdi zmdi-power"></i></a>
                </div>
            </li>
        </ul>
    </div>
</aside>
<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Dashboard
                <small class="text-muted">Welcome to Compass</small>
                </h2>
            </div>
            
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div>
                    <div class="card">
                    <!-- the index container -->
                        <div class="header">
                            <h2><strong>'.$classname.'</strong> <small>List Data</small> </h2>
                        </div>
                        <div class="alert alert-success" style="display: none" id="message_success"></div>
                        <div class="alert alert-danger" style="display: none" id="message_error"></div>
                          
                        
                                <div class="body table-responsive">
                                    <div class="panel panel-default">
                                        <div class="panel-body" id="primary-content">
                                        
                                            <!-- this is content -->
                                        </div>
                                    </div>
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
                                            $val = getColumnType($conn, $dbname, $tbname, $field);   
                                            if($val=="enum"){
                                                $cbo = ComboEnum($conn, $dbname, $tbname, $field);
                                                $temp .= "                                <div class=\"form-group\">
                                    <label>$field:</label>
                                ".$cbo."
                                </div>
";
                                                
                                            }elseif($val=="date"){
                                                $temp .= "                                <div class=\"form-group\">
                                    <label>$field:</label>
                                    <div class=\"input-group\">
                                        <span class=\"input-group-addon\">
                                            <i class=\"zmdi zmdi-calendar\"></i>
                                        </span>
                                        <input type=\"text\" class=\"form-control datetimepicker\" name=\"".$field."\" value=\"<%= ".$field." %>\">
                                    </div>
                                </div>\n";
                                            }else{
                                                $temp .= "                                <div class=\"form-group\">
                                    <label>$field:</label>
                                    <input type=\"text\" class=\"form-control\" name=\"".$field."\" value=\"<%=".$field." %>\" />
                                </div>\n";
                                            }
                                        }
                                        $i++; 
                                    }         
                                }
                            
$temp .='                                <button class="save btn btn-large btn-info" type="submit">Save</button>
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
                                            $temp .= "                                <div class=\"form-group\">
                                    <label>$field:</label>
                                    <input type=\"text\" class=\"form-control\" name=\"$field\" value=\"<%= $field %>\" disabled/>
                                </div>\n";
                                        }
                                        $i++; 
                                    }         
                                }
                                
$temp .='                                <button class="delete btn btn-large btn-danger" type="submit">Delete</button>
                                <a href="#index" class="btn btn-large btn-default">Cancel</a>
                            </form>
                        </div>
                    </div>
                </script>
                
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
        $temp .= "                               <th>$field</th>\n";
    }
    $i++;        
}

$temp .='                               <th width="140">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <% _.each(cruds, function (crud) { %>
                            <tr>
';
                                    $i=1;
                                    foreach ($fields as $field) {
                                        if($i<=$total){
                                            $temp .= "                              <td><%= crud.$field %></td>\n";
                                        }
                                        $i++;        
                                    }
                                        

    $temp .='                              <td class="text-center" width="200">
                                <a class="btn btn-info btn-sm" href="#<%= crud.id %>/edit"><i class="fa fa-pencil"></i></a>
                                <a class="btn btn-danger btn-sm" href="#<%= crud.id %>/deleteform"><i class="fa fa-trash"></i></a>
                              </td>
                            </tr>
                            <% }); %>
                        </tbody>
                    </table>
                    </div>
                </script>
                
            </div>
        </div>
    </div>
    
</section>
<!-- Include jQuery -->
<!-- jQuery (necessary for Bootstrap\'s JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdn.usebootstrap.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore.js"></script>
<script src="https://unpkg.com/backbone@1.3.3/backbone.js"></script>

<script src="../assets/plugins/momentjs/moment.js"></script> <!-- Moment Plugin Js --> 
<!-- Bootstrap Material Datetime Picker Plugin Js --> 
<script src="../assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script> 
<script src="../assets/plugins/bootstrap-notify/bootstrap-notify.js"></script> <!-- Bootstrap Notify Plugin Js -->
<script src="../assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js --> 
<script src="../assets/js/pages/forms/basic-form-elements.js"></script>  
<script src="../Models/'.$classname.'.js"></script>


</body>
</html>
';

echo printCode($temp);
?>