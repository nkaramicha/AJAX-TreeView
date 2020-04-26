<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Bootstrap's 3.3.7 version stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- jQuery 3.4.1 version library -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <title>Preload and AJAX TreeView</title>
    <style>

        ul {
            list-style-type: none;
        }
        
    	li {
    		background-image: url(images/dottedvertical.gif), url(images/dotted.gif);
    		background-repeat: repeat-y, no-repeat;
            background-position: left top, left 9px;
    		line-height: 18px;	
    		padding-left: 18px;
    	}
    	
    	li:last-child {
    		background-repeat: no-repeat;
    	}
    	
        .left li ul {
            display: none;
        }
        
        li a {
    	    background-repeat: no-repeat;
            background-position: left center;
            line-height: 18px;
            padding-left: 18px;
            margin-left: -9px;
        }
        
        /* Named the class expand1 to avoid duplication with Boostrap's expand class */
        a.ajax-expand,
        .expand1 {
            background: url(images/expand.gif);
            background-repeat: no-repeat;
            background-position: 3px;
        }
        
        /* Named the class collapse1 to avoid duplication with Boostrap's expand class */
        a.ajax-collapse,
        .collapse1 {
            background: url(images/collapse.gif);
            background-repeat: no-repeat;
            background-position: 3px;
        }
        
        .blank {
            background: url(images/blank.gif);
            background-repeat: no-repeat;
            background-position: 3px;
        }
        
        .header {
            padding: 10px;
            background: #77A240;
        }
        
        h3 {
            color: white;
        }
        
        p {
            padding: 10px;
        }
    
    </style>
</head>

<body>
    
    <div class="header">
        <h3>Preload and AJAX TreeView</h3>
        
        <!-- The button to change the views -->
        <button type="button" class="btn btn-dark">Change view</button>
    </div>


<?php

error_reporting(E_ALL);
ini_set('display_startup_errors','1');
ini_set('display_errors','1');


//Includes
require('myTreeView.class.php');

$treeView = new myTreeView();

// Set as current view the Full Tree view
echo '<div class="left"><p><b>Current view: Full Tree</b></p>';

$treeView->showCompleteTree();
echo '</div>';

// Set as current view the AJAX Tree view if the showNode function is executed
if (isset($_POST['entry']) && $_POST['entry']){
    echo '<div class="left"><p id="paragraph"><b>Current view: AJAX Tree</b></p>';
}
// Else show the Full Tree view
else{
    echo '<div class="right"><p id="paragraph"><b>Current view: Full Tree</b></p>';
} 

echo '</div>';

?>

<script>
    // Main function that is executed on body load
    $(function(){
        
        // Function to change the expand and collapse icons
        $(".expand1").click(function() {
            $("ul", $(this).parent()).eq(0).toggle();
            $(this).toggleClass("collapse1");
        });
        // Initially hide right div
        $(".right").hide();
        $("button").click(function(e){
            // On button click change the views
            $(".right").toggle();
            $(".left").toggle();
                // Check the active view by the text of the paragraph
                var x = document.getElementById("paragraph");
                if (x.innerHTML === "<b>Current view: Full Tree</b>") {
					x.innerHTML = "<b>Current view: AJAX Tree</b>";
                    showNode(0, document.getElementsByClassName('right')[0], e);
                } else {
                    x.innerHTML = "<b>Current view: Full Tree</b>";
                }
        });
        

    });
    
    // Function to call the ajaxNode.php file for fetchAjaxTree
    function showNode(nodeId, obj, event) {
        // Avoid the call on the parent object
        event.stopPropagation();
        // Check if the object has the ajax-collapse class
        if (!$( obj ).hasClass('ajax-collapse')) {
            var xmlhttp = new XMLHttpRequest();
            
            // Call ajaxNode.php file for the specific nodeId each time
            xmlhttp.open("POST", "ajaxNode.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("entry="+nodeId);
            
            xmlhttp.onreadystatechange = function() {
                
                // Check if the operation is complete and the is OK
                if(xmlhttp.readyState === XMLHttpRequest.DONE && xmlhttp.status === 200){
                    
        			
        			if (nodeId == 0) {
        			    // Remove the old ul, from the object
        			    $("ul", $(obj)).remove();
        			    // You click the button
        			    $( obj ).append(this.responseText);
        			} else {
        			    // Remove the old ul, from the parent
        			    $("ul", $(obj).parent()).remove();
        			    // You click the icon
        			    $( obj ).parent().append(this.responseText);
        			}
                }
                
    		};
    		
        } else {
            // Check if it's not the first call
            if (nodeId !== 0) {
                // Collapse the ul, from the parent
                $("ul", $(obj).parent()).eq(0).toggle();
            }
        }
	
	    // Toggle the classes
	    $( obj ).toggleClass("ajax-collapse");
        $( obj ).toggleClass("ajax-expand");
		
    };
    
</script>
</body>
</html>