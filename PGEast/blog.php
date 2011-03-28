<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Yet another crappy blog engine</title>
	<style  type='text/css'>
	div.comments {
		border: solid;
	}
	div.comment {
		padding-left: 15px;
		margin-top: 20px;
	}
	</style>
</head>
<body>
	<h1>Justin's Blog</h1>
<?php
	$server = new Mongo();
	$db = $server->my_blog;
	$collection = $db->articles;
	
	// Do we need to add a new comment
	if (array_key_exists('_id', $_REQUEST)) {
		$commentId = new MongoId($_REQUEST['_id']);
		$collection->update
			(Array('_id'=> $commentId),
				 Array('$push'=>Array('comments'=>Array(
				'name'=>$_REQUEST['name'],
				'comment'=>$_REQUEST['new_comment']
				)
			)
		));
	}

	function display_comments($document) {
		if (isset($document) && isset($document['comments']) && is_array($document['comments'])) {
			foreach ($document['comments'] as $comment) {
				echo '<div class="comment">&nbsp;&nbsp;&nbsp;<i>' . $comment['name'] . '</i> writes:<br/>';
				echo $comment['comment'];
				if (isset($comment['comments'])) {
					display_comments($comment);
				}
				echo "</div>\n";
			}
		}
	}

	$cursor = $collection->find()->sort(Array('_id'=> -1));
	foreach ($cursor as $obj) {
		echo '<div class="article">';
		echo '<h1>' . $obj["title"] . "</h1>\n";
		echo '<div>' . $obj["article"] . "</div>\n";
		echo '<div class="comments"><h2>Comments</h2>';
		display_comments($obj);
		echo '</div>' . "\n";
?>
<form method='post' action='blog.php'>
	<input type='hidden' name='_id' value='<?php echo $obj['_id'];?>'/>
	Name: <input type='name' name='name' value='Justin Dearing'/><br/>
	<textarea name='new_comment' rows='7' cols='30'></textarea><br/>
	<input type='submit' value='Add comment'/>
</form>
<?php
		echo '</div>' . "\n";
	}
	$server->close();
?>
</body>
</html>
