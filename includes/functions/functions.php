<?php

/*
get the latest record
*/

function getcat()
{
	global $con;
	$getcat = $con->prepare("SELECT * FROM categories ORDER BY ID DESC");
	$getcat->execute();
	$cats = $getcat->fetchAll();
	return $cats;
}


/*
get the latest record
*/

function getItem($where,$value)
{
	global $con;
	$getitem = $con->prepare("SELECT * FROM items WHERE $where = ? ORDER BY item_ID DESC");
	$getitem->execute(array($value));
	$items = $getitem->fetchAll();
	return $items;
}





/*
	** Get All Function v2.0
	** Function To Get All Records From Any Database Table
	*/

	function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC") {

		global $con;

		$getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

		$getAll->execute();

		$all = $getAll->fetchAll();

		return $all;

	}
/*
	** Check If User Is Not Activated
	** Function To Check The RegStatus Of The User
	*/

	function checkUserStatus($user) {

		global $con;

		$stmtx = $con->prepare("SELECT 
									Username, RegStatus 
								FROM 
									users 
								WHERE 
									Username = ? 
								AND 
									RegStatus = 0");

		$stmtx->execute(array($user));

		$status = $stmtx->rowCount();

		return $status;

	}


//set the title of the page

function getTitle()
{
	global $pageTitle;
	if(isset($pageTitle))
	{
		echo $pageTitle;
	}
	else
	{
		echo "default";
	}
}
/*
redirect function
this function accept paramter
$errmessag = echo error message
$seconde = second before redirectmessage
*/

function redirectHome($theMsg,$url=null,$seconds=3)

{
	if($url === null){
		$url = 'index.php';
	} else
	{
		if(isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER'] !== ''){
			$url = $_SERVER['HTTP_REFERER'];
		} else
		{
			$url = 'index.php';
		}
		
	}
	echo $theMsg;
	echo "<div class='alert alert-info'>you wiil Be direct to homepage after $seconds seconds.</div>";
	header("refresh:$seconds;url=$url");
	exit();
}

/*
functon to check Item in database
*/
function checkItem($select,$from,$value)
{
	global $con;
	$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
	$statement->execute(array($value));
	$count = $statement->rowCount();
	return $count;
}


/*
check numbers of item
*/
function countItems($item,$table)

{
         global $con;
		 $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
		 $stmt2->execute();
		 return $stmt2->fetchColumn();
}

/*
get the latest record
*/

function getLatest($select,$table,$limit=5)
{
	global $con;
	$getStmt = $con->prepare("SELECT $select FROM $table LIMIT $limit");
	$getStmt->execute();
	$rows = $getStmt->fetchAll();
	return $rows;
}