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
		$res = $dbh->query('SELECT * FROM clients ORDER BY '.$sortingField.' '.$sortingOrder.' LIMIT '.$firstRowIndex.', '.$rowsPerPage);
		 
		//сохраняем номер текущей страницы, общее количество страниц и общее количество записей
		$response = (object)array();
		$response->page = $curPage;
		$response->total = ceil($totalRows['count'] / $rowsPerPage);
		$response->records = $totalRows['count'];
	 
		$i=0;
		while($row = $res->fetch(PDO::FETCH_ASSOC)) {
			$response->rows[$i]['id']=$row['id'];
			$response->rows[$i]['cell']=array($row['id'], $row['fio'], $row['address'], $row['tel']);
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
        url: "inc/clients.php",
        datatype: "json",
        mtype: "POST",
        colNames: ["Код", "ФИО", "Адрес", "Телефон"],
        colModel: [
            { name: "id", width: 100 },
            { name: "fio", width: 100},
            { name: "address", width: 100, editable: true, edittype: 'text', editoptions: {size: 100, maxlengh: 100}},
            { name: "tel", width: 100, align: "right", sortable: false }
        ],
        pager: "#pager",
        rowNum: 10,
        rowList: [10, 20, 30],
        sortname: "id",
        sortorder: "asc",
        viewrecords: true,
        gridview: true,
        autoencode: true,
        caption: "Клиенты"
    }); 
}); 
</script>
<?
	$header = false;
}
else {
	?>
	<h1>Список клиентов</h1></br>
	<table id="list"><tr><td></td></tr></table> 
	<div id="pager"></div> 
	<?
}
?>