/**
 * domain, secretToken - from config.gs
 */
function sendRowWithColumnNamesToBackend() {
  // var ui = SpreadsheetApp.getUi(); 
  // ui.alert(JSON.stringify(sheet.getActiveRange().getNumRows()));
  


  var sheet = SpreadsheetApp.getActiveSpreadsheet().getActiveSheet();

  var range = sheet.getActiveRange();
  var startRow = range.getRow();
  var numRows = range.getNumRows();



  for (var i = 0; i < numRows; i++) {
    var currentRow = startRow + i;
    
    var numColumns = sheet.getLastColumn();
    var headers = sheet.getRange(1, 1, 1, numColumns).getValues()[0];
    var valuesToSend = sheet.getRange(currentRow, 1, 1, numColumns).getValues()[0];

    var sheetRowData = headers.reduce(function(dataObject, columnName, index) {
      dataObject[columnName] = valuesToSend[index];
      return dataObject;
    }, {});

    var requestOptions = {
      'method': 'post',
      'contentType': 'application/json',
      'payload': JSON.stringify({sheetRowData: sheetRowData}),
      'headers': {
        'Authorization': 'Bearer ' + secretToken
      },
    };

    var sheetName = sheet.getName();
    if (sheetName==='Pages') {
      UrlFetchApp.fetch(host+'/cms-sheets/page-update', requestOptions);
    } 
    else if (sheetName==='Menu') {
      UrlFetchApp.fetch(host+'/cms-sheets/menu-update', requestOptions);
    }
    else throw new Error('There is no handler for this sheet!');
  }

}