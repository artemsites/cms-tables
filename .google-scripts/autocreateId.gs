function autocreateId(e) {
  var idColumn = 1; 
  var startRow = 2; 

  var range = e.range;
  var sheet = range.getSheet();
  var editedRow = range.getRow();
  var editedColumn = range.getColumn();

  if (editedColumn === idColumn || editedRow < startRow) {
    return; 
  }

  var idCell = sheet.getRange(editedRow, idColumn);
  if (idCell.getValue() !== '') {
    return; 
  }
  
  var uniqueId = new Date().getTime();

  idCell.setValue(uniqueId);
}
