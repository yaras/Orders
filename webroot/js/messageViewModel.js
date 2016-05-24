function MessageViewModel() {
  var self = this;

  self.username = ko.observable('');
  self.date = ko.observable('');
  self.message = ko.observable('');

  self.deserialize = function(data) {
    self.username(data.Author.name);
    self.date(data.created.substr(0, 16).replace('T', ' '));
    self.message(data.message);
  }
}
