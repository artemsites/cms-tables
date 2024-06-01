function onOpen() {
  var ui = SpreadsheetApp.getUi();
  ui.createMenu('CMS Sheets')
    .addItem('Send to CMS Sheets', 'sendEntireRowToSymfonyWithColumnNames')
    .addToUi();

  // protectColumnA();
}


