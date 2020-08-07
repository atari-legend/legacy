/*!
 * tabulator.js
 */

window.initTabulator = function (JSdata) {
    // define some sample data
    var tabledata = JSdata;

    // create Tabulator on DOM element with id "example-table"
    $('#games-table').tabulator({
        responsiveLayout: true, // this option takes a boolean value (default = false)
        fitColumns: true,
        pagination: 'local',
        columns: [ // Define Table Columns
            { title: 'Name', field: 'game_name', sorter: 'string', align: 'left', headerFilter: 'input', minWidth: 150, responsive: 0, cellClick: function (e, cell) { window.location = '../games/games_detail.php?game_id=' + cell.getRow().getData().game_id } },
            { title: 'Developer', field: 'developer_name', sorter: 'string', align: 'left', headerFilter: 'input', minWidth: 150, cellClick: function (e, cell) { window.location = '../games/games_main_list.php?developer=' + cell.getRow().getData().developer_id + '&action=search&export=1' } },
            { title: 'Boxscan', field: 'boxscan', sorter: 'string', formatter: 'tickCross', headerFilter: 'input', width: 100, minWidth: 50 },
            { title: 'Screenshot', field: 'screenshot', sorter: 'string', formatter: 'tickCross', headerFilter: 'input', width: 120, minWidth: 50 },
            { title: 'Download', field: 'download', sorter: 'string', formatter: 'tickCross', headerFilter: 'input', width: 110, minWidth: 50 },
            { title: 'Music', field: 'music', sorter: 'string', formatter: 'tickCross', headerFilter: 'input', width: 75, minWidth: 50 }
        ]
    });
    $('#games-table').tabulator('setPageSize', 25); // show 25 rows per page

    // trigger download of data.csv file
    $('#download-csv').click(function () {
        $('#games-table').tabulator('download', 'csv', 'data.csv');
    });

    // trigger download of data.json file
    $('#download-json').click(function () {
        $('#games-table').tabulator('download', 'json', 'data.json');
    });

    // trigger download of data.xlsx file
    $('#download-xlsx').click(function () {
        $('#games-table').tabulator('download', 'xlsx', 'data.xlsx');
    });

    // load sample data into the table
    $('#games-table').tabulator('setData', tabledata);

    $(window).on('resize', function () {
        $('.tabulator').tabulator('redraw');
    });
}
