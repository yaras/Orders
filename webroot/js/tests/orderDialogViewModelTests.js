QUnit.test("not empty name and valid time are valid values", function( assert ) {
  var vm = new OrderDialogViewModel();

  vm.title('Order from restaurant X');
  vm.time('10:00');

  assert.ok(vm.verifyValues(), "Is valid");
});

QUnit.test("not empty name and time out of boundary is invalid", function( assert ) {
  var vm = new OrderDialogViewModel();

  vm.title('Order from restaurant X');
  vm.time('10:61');

  assert.notOk(vm.verifyValues(), "Is not valid");

  assert.ok(vm.timeError(), "Time should be invalid");
  assert.equal(vm.timeErrorMessage(), "Invalid time format, expectd: HH:MM", "Error message");
});
