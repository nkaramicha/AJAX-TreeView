<?php

class myTreeView{
	
        public function showCompleteTree() {
			
			// Include the PHP file for the database connection
			include ('dbconnection.php');
			// Select entry_id, name, lang from entry_lang table and parent_entry_id from entry table ordered in a way so later if there is a English version available to be prioritised from the German one.
			$sql = "SELECT entry_lang.entry_id, entry_lang.name, entry_lang.lang, entry.parent_entry_id FROM entry_lang LEFT JOIN entry ON entry_lang.entry_id = entry.entry_id ORDER BY entry.parent_entry_id , entry_lang.lang DESC, entry_lang.name ASC" or die(mysqli_error());
			$res = mysqli_query($link,$sql);
			
			while($row = mysqli_fetch_array($res)) {
                // Push the data in the array
                $completeArray[$row['entry_id']] = array('parent_entry_id' => $row['parent_entry_id'], 'name' => $row['name']);
			}
			// Call createTree function with the SQL query that previously performed, the parentId as 0 and the flag also as 0
			$this->createTree($completeArray, 0, 0);
			
		}
		
		// Flag is 0 for showCompleteTree function and 1 for fetchAjaxTreeNode() function
		function createTree($resultsArray, $parentId, $flag, $current = 0, $previous = -1) {
		    
		    // Check the flag variable and then proceed based on the result, 0 for showCompleteTree function and 1 for fetchAjaxTreeNode function
		    if ($flag == 0){   
    		    foreach ($resultsArray as $nodeId => $node) {
    		        
    		        // Check if the given node's id is equal with each node's parent id in the array
    			    if ($parentId == $node['parent_entry_id']) {
    			        
    			        // If the current level is bigger than the previous level, I create an new ul
                        if ($current > $previous) echo '<ul class="full">';
                        
                        // If the current level is equal to the previous level, I close the open li
                        if ($current == $previous) echo "</li>";
                     
                        $hasChilds = false;
                        
                        // For each node, I check if the node has childs and set the flag hasChilds to true
                        foreach($resultsArray as $child) {
    	                    if ($child['parent_entry_id'] == $nodeId) {
    		                    $hasChilds = true;
    		                    break;
    	                    }
                        }
                        // I open a new li
                        echo '<li>';
                        
                        // If the node has childs then the icon is expand, otherwise is blank
                        if ($hasChilds) echo '<a class="expand1">'.$node['name'].'</a>';
                        else echo "<a class='blank'>".$node['name']."</a>";
    
                        // I set the previous level equal to the current level
                        if ($current > $previous)  $previous = $current;
                     
                        // Then I increase the current level by one
                        $current++; 
                        
                        // I call the function createTree with the new variables
                        $this->createTree ($resultsArray, $nodeId, $flag, $current, $previous);
                     
                        // And finally I decrease the current level by one
                        $current--;               
                    }   
                  
                }
               // If the current level is equal to the previous level I close all the open li and ul
               if ($current == $previous) echo "</li></ul>";
               
		    }
		    // Check the flag if showCompleteTree was called from fetchAjaxTreeNode function
		    else if ($flag = 1){
		        
		        foreach ($resultsArray as $nodeId => $node) {
		            
		            // Check if the given node's id is equal with each node's parent id in the array
    			    if ($parentId == $node['parent_entry_id']) {
    			        
    			        // If the current level is bigger than the previous level, I create an new ul
                        if ($current > $previous) echo '<ul>';
                        
                        // If the current level is equal to the previous level, I close the open li
                        if ($current == $previous) echo '</li>';
                     
                        // Set the flag hasChilds based on the returned value of checkChilds node
                        $hasChilds = $this->checkChilds($nodeId);
                        
                        
                        // I open a new li
                        echo '<li>';
                        
                        // If the node has childs then the icon is expand and onclick action the showNode function is called, with the variable equal to the node's id, otherwise is blank
                        if ($hasChilds) echo '<a class="ajax-expand" onclick="showNode('.$node['entry_id'].', this, event)">'.$node['name'].'</a>';
                        else echo "<a class='blank'>".$node['name']."</a>";
    
                        // I set the previous level equal to the current level
                        if ($current > $previous) $previous = $current;
                     
                        // Then I increase the current level by one
                        $current++; 
                        
                        // I call the function createTree with the new variables
                        $this->createTree ($resultsArray, $nodeId, $flag, $current, $previous);
                     
                        // And finally I decrease the current level by one
                        $current--;               
                    }   
                  
                }
               // If the current level is equal to the previous level I close all the open li and ul
               if ($current == $previous) echo "</li></ul>";
		    }
		}
		
		// Function to check if the node has childs for ajax tree view
		public function checkChilds($entry_id) {
		    // Push the data in the array
		    include ('dbconnection.php');
		    
		    // Query to count if the node has childs
            $sql = "SELECT COUNT(entry_lang.entry_id) FROM entry_lang LEFT JOIN entry ON entry_lang.entry_id = entry.entry_id WHERE entry.parent_entry_id = $entry_id" or die(mysqli_error());
			
			$res = mysqli_query($link,$sql);
			
			// Return the result of the query
			while($row = mysqli_fetch_array($res)) {
                return ($row[0] > 0);
			}
			
		}
		
		
		public function showAjaxTree() {
            
		}
		
		public function fetchAjaxTreeNode($entry_id) {
		    
			// Include the PHP file for the database connection
			include ('dbconnection.php');
			
			// The first sql query selects entry_id, name, lang from entry_lang table and parent_entry_id from entry table ordered in a way so later if there is a English version available to be prioritised from the German one, where the parent id of the node is equal to 0 and the node's id
			$sql = "SELECT entry_lang.entry_id, entry_lang.name, entry_lang.lang, entry.parent_entry_id FROM entry_lang LEFT JOIN entry ON entry_lang.entry_id = entry.entry_id WHERE entry.parent_entry_id = ".$entry_id." ORDER BY entry.parent_entry_id , entry_lang.lang DESC, entry_lang.name ASC" or die(mysqli_error());
			
			$res = mysqli_query($link,$sql);
			
			while($row = mysqli_fetch_assoc($res)) {
                
                // The second sql query selects entry_id, name, lang from entry_lang table and parent_entry_id from entry table ordered in a way so later if there is a English version available to be prioritised from the German one, where the node's id is equal to the node's parent id or the node's parent id is equal to
                    $sql2 = "SELECT entry_lang.entry_id, entry_lang.name, entry_lang.lang, entry.parent_entry_id FROM entry_lang LEFT JOIN entry ON entry_lang.entry_id = entry.entry_id WHERE entry.parent_entry_id = ".$entry_id." ORDER BY entry.parent_entry_id , entry_lang.lang DESC, entry_lang.name ASC";
 
                $res2 = mysqli_query($link,$sql2);
                while($row2 = mysqli_fetch_assoc($res2)) {
                    // Push the data in the array
                    $ajaxArray[$row2['entry_id']] = array('entry_id' => $row2['entry_id'], 'parent_entry_id' => $row2['parent_entry_id'], 'name' => $row2['name']);
                }
                
            }

            // Call createTree function with the SQL queries that previously performed, the parentId as 0 and the flag as 1
			$this->createTree($ajaxArray, $entry_id, 1);
		}
}

?>