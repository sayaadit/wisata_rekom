$.extend(true, $.fn.dataTable.defaults, {
	"language": { // language settings
		// metronic spesific
		"metronicGroupActions": "_TOTAL_ records selected:  ",
		"metronicAjaxRequestGeneralError": "Could not complete request. Please check your internet connection",
	
		// data tables spesific
		"lengthMenu": "<span class='seperator'>|</span>View _MENU_ records",
		"info": "<span class='seperator'>|</span>Found total _TOTAL_ records",
		"infoEmpty": "No records found to show",
		"emptyTable": "No data available in table",
		"zeroRecords": "No matching records found",
		"paginate": {
			"previous": "Prev",
			"next": "Next",
			"last": "Last",
			"first": "First",
			"page": "Page",
			"pageOf": "of"
		}
	},
	"lengthMenu": [
		[10, 20, 30, 50, 100, 150, -1],
		[10, 20, 30, 50, 100, 150, "All"]
	],
	"bStateSave": true,
	"pageLength": 30, // default records per page
	"ajax": { // define ajax settings
		"url": "", // ajax URL
		"type": "POST", // request type
		"timeout": 20000
	},
	"pagingType": "bootstrap_extended", // pagination type(bootstrap, bootstrap_full_number or bootstrap_extended)
	"autoWidth": false, // disable fixed width and enable fluid table
	"processing": true, // enable/disable display message box on record load
	"serverSide": true, // enable/disable server side ajax loading
});