// function protectColumnA() {
//   var sheet = SpreadsheetApp.getActiveSpreadsheet().getActiveSheet();
//   var range = sheet.getRange('A:A');

//   var protection = range.protect().setDescription('Protected Column');

//   var me = Session.getEffectiveUser();
//   protection.addEditor(me);
//   protection.removeEditors(protection.getEditors().filter(function(editor) {
//     return editor.getEmail() !== me.getEmail();
//   }));

//   protection.setWarningOnly(true);
// }



// var sheet = SpreadsheetApp.getActiveSpreadsheet().getActiveSheet();
// var range = sheet.getRange('A:A'); 

// var validationRule = SpreadsheetApp.newDataValidation()
//   .requireTextEqualTo('LOCKED COLUMN A')
//   .setAllowInvalid(false)
//   .setHelpText('This column is protected and cannot be edited!')
//   .build();

// range.setDataValidation(validationRule);


  
  
  
  
// function protectColumnA() {
//   var sheet = SpreadsheetApp.getActiveSpreadsheet().getActiveSheet();
//   var rangeToProtect = sheet.getRange('A:A');
//   var protections = sheet.getProtections(SpreadsheetApp.ProtectionType.RANGE);
//   var isAlreadyProtected = protections.some(function(protection) {
//     var protectedRange = protection.getRange();
//     // Check if the new range to protect is fully within an existing protected range
//     return rangeToProtect.getRowIndex() >= protectedRange.getRowIndex() &&
//            rangeToProtect.getLastRow() <= protectedRange.getLastRow() &&
//            rangeToProtect.getColumn() == protectedRange.getColumn() &&
//            rangeToProtect.getLastColumn() == protectedRange.getLastColumn();
//   });

//   if (!isAlreadyProtected) {
//     var protection = rangeToProtect.protect().setDescription('Protected Column');

//     // Ensure the current user is an editor before removing others.
//     var me = Session.getEffectiveUser();
//     protection.addEditor(me);
//     protection.removeEditors(protection.getEditors().filter(function(editor) {
//       return editor.getEmail() !== me.getEmail();
//     }));

//     // Optionally set as warning only, will show a warning when editing the protected range
//     // but not fully prevent the edit.
//     protection.setWarningOnly(true);
    
//     // Uncomment the above line if you want to show a warning instead of blocking edits.
//   } else {
//     Logger.log('Column A is already protected.');
//   }
// }
