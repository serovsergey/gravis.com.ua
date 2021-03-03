<?
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // Если к нам идёт Ajax запрос, то ловим его
	try {
		//читаем параметры
		$curPage = $_POST['page'];
		$rowsPerPage = $_POST['rows'];
		$sortingField = $_POST['sidx'];
		$sortingOrder = $_POST['sord'];
		 
		//подключаемся к базе
		$dbh = new PDO('mysql:host=cloud503.nic.ua;dbname=gravisco_account', 'gravisco_moskal', 'ssa260579');
		//указываем, мы хотим использовать utf8
		$dbh->exec('SET CHARACTER SET utf8');
	 
		//определяем количество записей в таблице
		$rows = $dbh->query('SELECT COUNT(id) AS count FROM contracts');
		$totalRows = $rows->fetch(PDO::FETCH_ASSOC);
	 
		$firstRowIndex = $curPage * $rowsPerPage - $rowsPerPage;
		//получаем список пользователей из базы
		$res = $dbh->query('SELECT * FROM contracts ORDER BY '.$sortingField.' '.$sortingOrder.' LIMIT '.$firstRowIndex.', '.$rowsPerPage);
		 
		//сохраняем номер текущей страницы, общее количество страниц и общее количество записей
		$response = (object)array();
		$response->page = $curPage;
		$response->total = ceil($totalRows['count'] / $rowsPerPage);
		$response->records = $totalRows['count'];
	 
		$i=0;
		while($row = $res->fetch(PDO::FETCH_ASSOC)) {
			$response->rows[$i]['id']=$row['id'];
			$response->rows[$i]['cell']=array($row['id'], $row['number'], $row['cdate'], $row['client_id']);
			$i++;
		}
		echo json_encode($response);
	}
	catch (PDOException $e) {
		echo 'Database error: '.$e->getMessage();
	}
    exit;
}
//Если это не ajax запрос
if($header) {
	?>
	<script type="text/javascript">
$(function () {
    $("#list").jqGrid({
		regional: "ru",
        url: "inc/contracts.php",
		editurl: "ec",
        datatype: "json",
        mtype: "POST",
		autowidth: true,
        colNames: ["Код", "Номер", "Дата", "Код клиента"],
        colModel: [
            { name: "id", width: 100 },
            { name: "number", width: 100},
            { name: "cdate", width: 100, align: "center",formatter: 'date',
												  formatoptions: {
													  srcformat: 'ISO8601Long',
													  newformat: 'd.m.Y',
													  defaultValue:null // does nothing!
												  },
												  editable: true,
												  edittype: 'text',
												  editoptions: {
													  size: 12,
													  maxlengh: 12,
													  dataInit: function (element) {
														  $(element).datepicker({ dateFormat: 'mm/dd/yy' }
																	)
													  }
												  },
												  editrules: {
													  date: true
												  }},
            { name: "client_id", width: 100, align: "right", sortable: false }
        ],
        pager: "#pager",
        rowNum: 10,
        rowList: [10, 20, 30],
        sortname: "id",
        sortorder: "asc",
        viewrecords: true,
        gridview: true,
        autoencode: true/*,
        caption: "Договора"*/
    }); 
}); 
</script>
<?
	$header = false;
}
else {
	?>
	<h1>Реестр договоров</h1></br>
	<table id="list" style="margin: auto;"><tr><td></td></tr></table> 
	<div id="pager"></div> 
	<?
}
?>