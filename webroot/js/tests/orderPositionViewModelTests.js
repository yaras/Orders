QUnit.test("not empty meal and valid hour are valid values", function( assert ) {
  var vm = new OrderPositionViewModel();

  vm.meal('Burger');
  vm.cost('21,50');

  assert.ok(vm.verifyValues(), "Is valid");
});

QUnit.test("empty meal is not valid", function( assert ) {
  var vm = new OrderPositionViewModel();

  vm.meal('');

  assert.notOk(vm.verifyValues(), "Is not valid");
  assert.equal(vm.mealError(), true, "Meal is not valid");
  assert.equal(vm.mealErrorMessage(), "Meal name must not be empty", "Meal error message");
});

QUnit.test("empty cost is not valid", function( assert ) {
  var vm = new OrderPositionViewModel();

  vm.meal('Test');
  vm.cost('');

  assert.notOk(vm.verifyValues(), "Is not valid");

  assert.equal(vm.mealError(), false, "Meal is valid");

  assert.equal(vm.costError(), true, "Cost is not valid");
  assert.equal(vm.costErrorMessage(), "Invalid cost format, expectd: 9,99", "Cost message");
});

QUnit.test("invalid cost format", function( assert ) {
  var vm = new OrderPositionViewModel();

  vm.meal('Test');
  vm.cost('aa');

  assert.notOk(vm.verifyValues(), "Is not valid");

  assert.equal(vm.mealError(), false, "Meal is valid");

  assert.equal(vm.costError(), true, "Cost is not valid");
  assert.equal(vm.costErrorMessage(), "Invalid cost format, expectd: 9,99", "Cost message");
});
